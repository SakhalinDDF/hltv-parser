<?php

declare(strict_types=1);

namespace common\models;

use Symfony\Component\DomCrawler\Crawler;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property string $status
 * @property string $url
 * @property string $created_at
 *
 * @property Team   $team
 */
class Request extends ActiveRecord
{
    public const STATUS_NEW    = 'new';
    public const STATUS_PARSED = 'parsed';
    public const STATUS_ERROR  = 'error';

    public static function tableName(): string
    {
        return 'request';
    }

    public function rules(): array
    {
        return [
            [['status', 'url'], 'required'],
            [['status'], 'in', 'range' => [self::STATUS_NEW, self::STATUS_PARSED, self::STATUS_ERROR]],
            [['url'], 'url'],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'status',
            'url',
            'team',
            'created_at',
        ];
    }

    public function parse(): void
    {
        if ($this->status !== self::STATUS_NEW) {
            return;
        }

        $this->parseTeam();
        $this->parsePlayers();
    }

    private function parseTeam(): void
    {
        if ($this->team !== null) {
            return;
        }

        $html         = $this->getHtml($this->url);
        $crawler      = new Crawler($html, \parse_url($this->url, PHP_URL_PATH));
        $teamNameNode = $crawler->filter('.context-item-name');

        if ($teamNameNode->count() !== 1) {
            $this->status = self::STATUS_ERROR;
            $this->save();

            return;
        }

        $team = new Team();

        $team->request_id = $this->id;
        $team->name       = \trim($teamNameNode->eq(0)->text());

        $statNodes = $crawler->filter('.stats-team-overview .columns .standard-box');

        $statNodes->each(function (Crawler $statNode) use ($team) {
            $name  = \trim($statNode->filter('.small-label-below')->eq(0)->text());
            $value = \trim($statNode->filter('.large-strong')->eq(0)->text());

            switch ($name) {
                case 'Maps played':
                    $team->maps_played = (int) $value;
                    break;

                case 'Wins / draws / losses':
                    $values       = \array_map('intval', \array_map('trim', \explode('/', $value)));
                    $team->wins   = $values[0];
                    $team->draws  = $values[1];
                    $team->losses = $values[2];
                    break;

                case 'Total kills':
                    $team->total_kills = (int) $value;
                    break;

                case 'Total deaths':
                    $team->total_deaths = (int) $value;
                    break;

                case 'Rounds played':
                    $team->round_played = (int) $value;
                    break;

                case 'K/D Ratio':
                    $team->kd_ratio = (float) $value;
                    break;
            }
        });

        if ($team->validate() === false) {
            $this->status = self::STATUS_ERROR;
            $this->save();

            return;
        }

        $team->save();

        $team->populateRelation('request', $this);
        $this->populateRelation('team', $team);
    }

    private function parsePlayers(): void
    {
        $html        = $this->getHtml($this->url);
        $crawler     = new Crawler($html, \parse_url($this->url, PHP_URL_PATH));
        $playersLink = $crawler->filterXPath("//a[contains(normalize-space(@class), 'stats-top-menu-item-link') and contains(text(), 'Players')]");

        if ($playersLink->count() !== 1) {
            $this->status = self::STATUS_ERROR;
            $this->save();

            return;
        }

        $playersUrl = \parse_url($this->url, PHP_URL_SCHEME) . '://' . \parse_url($this->url, PHP_URL_HOST) . $playersLink->attr('href');
        $html       = $this->getHtml($playersUrl);
        $crawler    = new Crawler($html, \parse_url($playersUrl, PHP_URL_PATH));

        $playerNodes = $crawler->filter('table.player-ratings-table tbody tr');
        $players     = [];

        $playerNodes->each(function (Crawler $playerNode) use (&$players) {
            $nicknameNode = $playerNode->filter('.playerCol a');
            $mapsNode     = $playerNode->filter('.statsDetail');
            $kdDiffNode   = $playerNode->filter('.kdDiffCol');
            $kdNode       = $playerNode->filter('.statsDetail');
            $ratingNode   = $playerNode->filter('.ratingCol');

            if ($nicknameNode->count() !== 1) {
                return;
            }

            $player = new Player();

            $player->team_id  = $this->team->id;
            $player->nickname = \trim($nicknameNode->text());
            $player->maps     = (int) \trim($mapsNode->text());
            $player->kd_diff  = (float) \trim($kdDiffNode->text());
            $player->kd       = (float) \trim($kdNode->text());
            $player->rating   = (float) \trim($ratingNode->text());

            $player->save();

            $player->populateRelation('team', $this);

            $players[] = $player;
        });

        $this->populateRelation('players', $players);
    }

    private function getHtml(string $url): string
    {
        return \Yii::$app->getCache()->getOrSet('request:html:' . \md5($url), function () use ($url) {
            $ch = \curl_init();

            \curl_setopt_array($ch, [
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_URL            => $url,
            ]);

            return \curl_exec($ch);
        });
    }

    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['request_id' => 'id'])->inverseOf('request');
    }
}

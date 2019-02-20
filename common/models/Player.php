<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property int    $team_id
 * @property string $nickname
 * @property int    $maps
 * @property float  $kd_diff
 * @property float  $kd
 * @property float  $rating
 */
class Player extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'player';
    }

    public function rules(): array
    {
        return [
            [['team_id', 'nickname', 'maps', 'kd_diff', 'kd', 'rating'], 'required'],
            [['team_id', 'maps'], 'integer'],
            [['kd_diff', 'kd', 'rating'], 'double'],
            [
                ['team_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Team::class,
                'targetAttribute' => 'id',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'team_id',
            'nickname',
            'maps',
            'kd_diff',
            'kd',
            'rating',
        ];
    }

    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }
}

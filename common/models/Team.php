<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int     $id
 * @property int     $request_id
 * @property string  $name
 * @property int     $maps_played
 * @property int     $wins
 * @property int     $draws
 * @property int     $losses
 * @property int     $total_kills
 * @property int     $total_deaths
 * @property int     $round_played
 * @property float   $kd_ratio
 * @property string  $parsed_at
 *
 * @property Request $request
 */
class Team extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'team';
    }

    public function rules(): array
    {
        return [
            [['request_id', 'name', 'maps_played', 'wins', 'draws', 'losses', 'total_kills', 'total_deaths', 'round_played', 'kd_ratio'], 'required'],
            [['request_id', 'maps_played', 'wins', 'draws', 'losses', 'total_kills', 'total_deaths', 'round_played'], 'integer'],
            [
                ['request_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Request::class,
                'targetAttribute' => 'id',
            ],
            [['name'], 'string', 'max' => 255],
            [['kd_ratio'], 'double'],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'request_id',
            'name',
            'maps_played',
            'wins',
            'draws',
            'losses',
            'total_kills',
            'total_deaths',
            'round_played',
            'kd_ratio',
            'players',
            'parsed_at',
        ];
    }

    public function getRequest(): ActiveQuery
    {
        return $this->hasOne(Request::class, ['id' => 'request_id'])->inverseOf('team');
    }

    public function getPlayers(): ActiveQuery
    {
        return $this->hasMany(Player::class, ['team_id' => 'id'])->inverseOf('team');
    }
}

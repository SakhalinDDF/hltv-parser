<?php

use yii\db\Migration;

/**
 * Class m190218_150727_add_base_migration
 */
class m190218_150727_add_base_tables extends Migration
{
    public function safeUp()
    {
        $sql = <<<SQL
CREATE TABLE `request` (
    `id`           INT(11)      UNSIGNED AUTO_INCREMENT NOT NULL,
    `status`       VARCHAR(32)  NOT NULL,
    `url`          VARCHAR(255) NOT NULL,
    `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE InnoDB CHARACTER SET utf8;
SQL;
        $this->execute($sql);

        $sql = <<<SQL
CREATE TABLE `team` (
    `id`           INT(11)      UNSIGNED AUTO_INCREMENT NOT NULL,
    `request_id`   INT(11)      UNSIGNED NOT NULL,
    `name`         VARCHAR(255) NOT NULL,
    `maps_played`  INT(11)      NOT NULL,
    `wins`         INT(11)      NOT NULL,
    `draws`        INT(11)      NOT NULL,
    `losses`       INT(11)      NOT NULL,
    `total_kills`  INT(11)      NOT NULL,
    `total_deaths` INT(11)      NOT NULL,
    `round_played` INT(11)      NOT NULL,
    `kd_ratio`     FLOAT        NOT NULL,
    `parsed_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`request_id`) REFERENCES `request` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE InnoDB CHARACTER SET utf8;
SQL;
        $this->execute($sql);

        $sql = <<<SQL
CREATE TABLE `player` (
    `id`         INT(11)      UNSIGNED AUTO_INCREMENT NOT NULL,
    `team_id`    INT(11)      UNSIGNED NOT NULL,
    `nickname`   VARCHAR(255) NOT NULL,
    `maps`       INT(11)      NOT NULL,
    `kd_diff`    FLOAT        NOT NULL,
    `kd`         FLOAT        NOT NULL,
    `rating`     FLOAT        NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`team_id`) REFERENCES `team`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE InnoDB CHARACTER SET utf8;
SQL;
        $this->execute($sql);
    }

    public function safeDown()
    {
        $this->dropTable('player');
        $this->dropTable('team');
        $this->dropTable('request');
    }
}

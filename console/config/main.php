<?php

declare(strict_types=1);

use yii\log\FileTarget;

return \yii\helpers\ArrayHelper::merge(require APP_ROOT . '/common/config/main.php', [
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap'       => [
        'migrate' => [
            'class'         => \yii\console\controllers\MigrateController::class,
            'templateFile'  => '@yii/views/migration.php',
            'migrationPath' => '@console/migrations',
        ],
        'serve'   => [
            'class'   => \yii\console\controllers\ServeController::class,
            'docroot' => WEB_ROOT,
        ],
    ],
    'components'          => [
        'log'        => [
            'targets' => [
                [
                    'class'   => FileTarget::class,
                    'levels'  => ['error', 'warning'],
                    'logFile' => '@runtime/logs/console.log',
                ],
            ],
        ],
        'urlManager' => [
            'baseUrl'  => WEB_URL,
            'hostInfo' => WEB_URL,
        ],
    ],
]);

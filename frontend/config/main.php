<?php

declare(strict_types=1);

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require APP_ROOT . '/common/config/main.php', [
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'assetManager' => [
            'class'      => \yii\web\AssetManager::class,
            'linkAssets' => true,
        ],
        'errorHandler' => [
            'class'       => \yii\web\ErrorHandler::class,
            'errorAction' => 'site/error',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'   => \yii\log\FileTarget::class,
                    'levels'  => ['error', 'warning'],
                    'logFile' => '@runtime/logs/frontend.log',
                    'logVars' => ['_GET', '_POST', '_FILES', '_SERVER'],
                ],
            ],
        ],
        'response'     => [
            'class' => \yii\web\Response::class,
        ],
        'request'      => [
            'class' => \yii\web\Request::class,
        ],
        'user'         => [
            'class'         => \yii\web\User::class,
            'identityClass' => \common\models\User::class,
        ],
    ],
    'modules'             => [
        'api' => [
            'class' => \api\Module::class,
        ],
    ],
    'viewPath'            => '@frontend/views',
], require __DIR__ . '/main.local.php');

<?php

return [
    'id'          => 'hltv-parser',
    'basePath'    => APP_ROOT,
    'bootstrap'   => ['log'],
    'components'  => [
        'cache'      => [
            'class' => \yii\caching\FileCache::class,
        ],
        'db'         => [
            'class'               => \yii\db\Connection::class,
            'dsn'                 => 'mysql:host=' . \getenv('DB_HOST') . ';dbname=' . \getenv('DB_NAME') . ';dbport=' . \getenv('DB_PORT'),
            'username'            => \getenv('DB_USER'),
            'password'            => \getenv('DB_PASS'),
            'charset'             => 'utf8',
            'enableSchemaCache'   => true,
            'schemaCacheDuration' => YII_ENV_DEV ? 600 : 86400,
            'schemaCache'         => 'cache',
        ],
        'urlManager' => [
            'class'               => \yii\web\UrlManager::class,
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => false,
            'normalizer'          => [
                'class'                  => \yii\web\UrlNormalizer::class,
                'collapseSlashes'        => true,
                'normalizeTrailingSlash' => true,
            ],
            'rules'               => require __DIR__ . '/rules.php',
            'showScriptName'      => false,
            'suffix'              => '/',
        ],
    ],
    'name'        => 'HLTV parser',
    'runtimePath' => '@common/runtime',
];

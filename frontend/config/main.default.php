<?php

declare(strict_types=1);

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
    ],
];

$allowedIPs = [
    '10.*',
    '127.*',
    '192.168.*',
];

if (YII_ENV_PROD === false) {
    $config['bootstrap'][] = 'debug';
    $config['bootstrap'][] = 'gii';

    $config['modules']['debug'] = [
        'class'      => \yii\debug\Module::class,
        'allowedIPs' => $allowedIPs,
        'dirMode'    => DIR_MODE,
    ];

    $config['modules']['gii'] = [
        'class'       => \yii\gii\Module::class,
        'allowedIPs'  => $allowedIPs,
        'newDirMode'  => DIR_MODE,
        'newFileMode' => FILE_MODE,
    ];
}

return $config;

<?php

declare(strict_types=1);

class Yii extends \yii\BaseYii
{
    public static $aliases = [
        '@yii'          => APP_ROOT . '/vendor/yiisoft/yii2',
        '@node_modules' => APP_ROOT . '/node_modules',
        '@common'       => APP_ROOT . '/common',
        '@runtime'      => APP_ROOT . '/common/runtime',
        '@console'      => APP_ROOT . '/console',
        '@frontend'     => APP_ROOT . '/frontend',
        '@webroot'      => WEB_ROOT,
        '@web'          => '',
    ];
}

\spl_autoload_register(['Yii', 'autoload'], true, true);

\Yii::$container = new \yii\di\Container();

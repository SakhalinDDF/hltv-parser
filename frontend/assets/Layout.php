<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Layout extends AssetBundle
{
    public $sourcePath = '@frontend/assets/layout';

    public $css = [
        'layout.css',
    ];

    public $js = [
        'layout.js',
    ];

    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}

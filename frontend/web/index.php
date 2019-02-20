<?php

declare(strict_types=1);

\define('APP_ROOT', \dirname(\dirname(__DIR__)));

require APP_ROOT . '/vendor/autoload.php';

(function () {
    (new \Dotenv\Dotenv(\dirname(\dirname(__DIR__))))->load();

    require APP_ROOT . '/common/config/define.php';
    require APP_ROOT . '/common/Yii.php';
    require APP_ROOT . '/common/config/bootstrap.php';
    require APP_ROOT . '/frontend/config/bootstrap.php';

    (new \yii\web\Application(require APP_ROOT . '/frontend/config/main.php'))->run();
})();

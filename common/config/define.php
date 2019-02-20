<?php

declare(strict_types=1);

\defined('APP_ROOT') or \define('APP_ROOT', \dirname(\dirname(__DIR__)));
\defined('WEB_ROOT') or \define('WEB_ROOT', APP_ROOT . '/frontend/web');

\define('WEB_HOSTNAME', \getenv('WEB_HOSTNAME'));
\define('WEB_PROTOCOL', \getenv('WEB_PROTOCOL'));
\define('WEB_URL', WEB_PROTOCOL . '://' . WEB_HOSTNAME);

\define('PHP_BIN', \getenv('PHP_BIN') ? : '/usr/bin/php');

\define('DIR_MODE', 02775);
\define('FILE_MODE', 0664);

\define('YII_DEBUG', (bool) \getenv('APP_DEBUG'));
\define('YII_ENV', \getenv('APP_ENV'));

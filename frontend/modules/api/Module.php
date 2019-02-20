<?php

namespace api;

use common\rest\ErrorHandler;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\\controllers';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init(): void
    {
        if (empty(\Yii::$app->modules['debug']) === false) {
            /**
             * @var \yii\debug\Module $debug
             */
            $debug = \Yii::$app->modules['debug'];

            \Yii::$app->getView()->off(\yii\web\View::EVENT_END_BODY, [$debug, 'renderToolbar']);
            \Yii::$app->getResponse()->off(\yii\web\Response::EVENT_AFTER_PREPARE, [$debug, 'setDebugHeaders']);
        }

        \Yii::$app->getErrorHandler()->unregister();

        \Yii::$app->set('errorHandler', [
            'class'       => ErrorHandler::class,
            'errorAction' => '/api/default/error',
        ]);

        \Yii::$app->getErrorHandler()->register();
    }
}

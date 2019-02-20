<?php

namespace api\controllers;

use common\rest\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function accessRules(): array
    {
        return [
            [
                'allow'   => true,
                'actions' => ['error'],
            ],
            [
                'allow' => false,
            ],
        ];
    }

    public function actionError()
    {
        $exception = \Yii::$app->getErrorHandler()->exception ? : new NotFoundHttpException();

        return \Yii::$app->getErrorHandler()->convertExceptionToArray($exception);
    }
}

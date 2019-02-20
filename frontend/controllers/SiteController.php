<?php

declare(strict_types=1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    public function actions(): array
    {
        return [
            'error' => ErrorAction::class,
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
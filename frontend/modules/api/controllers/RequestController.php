<?php

namespace api\controllers;

use common\models\Request;
use common\rest\Controller;
use api\actions\request\View;
use api\actions\request\Create;
use api\actions\request\Update;
use api\actions\request\Delete;
use yii\web\NotFoundHttpException;

class RequestController extends Controller
{
    public function accessRules(): array
    {
        return [
            [
                'allow'   => true,
                'actions' => ['view'],
                'verbs'   => ['GET'],
            ],
            [
                'allow'   => true,
                'actions' => ['create'],
                'verbs'   => ['POST'],
            ],
            [
                'allow'   => true,
                'actions' => ['update'],
                'verbs'   => ['PUT'],
            ],
            [
                'allow'   => true,
                'actions' => ['delete'],
                'verbs'   => ['DELETE'],
            ],
            [
                'allow' => false,
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'view'   => View::class,
            'create' => Create::class,
            'update' => Update::class,
            'delete' => Delete::class,
        ];
    }

    public function findModel(int $id): Request
    {
        $query = Request::find();

        $query->andWhere(['id' => $id]);

        /**
         * @var Request
         */
        $model = $query->one();

        if ($model === null) {
            throw new NotFoundHttpException('Request not found');
        }

        return $model;
    }
}

<?php

declare(strict_types=1);

namespace common\rest;

use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use yii\web\Response;

abstract class Controller extends \yii\rest\Controller
{
    public $enableCsrfValidation = false;
    public $serializer           = [
        'class'              => Serializer::class,
        'collectionEnvelope' => 'data',
    ];

    public function behaviors(): array
    {
        $behaviors = [
            'contentNegotiator' => [
                'class'   => ContentNegotiator::class,
                'formats' => [
                    'application/json'       => Response::FORMAT_JSON,
                    'application/javascript' => Response::FORMAT_JSON,
                    'application/xml'        => Response::FORMAT_XML,
                    'application/xml+dtd'    => Response::FORMAT_XML,
                    'application/atom+xml'   => Response::FORMAT_XML,
                    'application/soap+xml'   => Response::FORMAT_XML,
                    '*/*'                    => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter'        => [
                'class'   => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'rateLimiter'       => [
                'class' => RateLimiter::class,
            ],
        ];

        $accessRules = $this->accessRules();

        if (\count($accessRules) !== 0) {
            $behaviors['access'] = [
                'class'        => AccessControl::class,
                'rules'        => $accessRules,
                'denyCallback' => function () {
                    throw new UnauthorizedHttpException();
                },
            ];
        }

        return $behaviors;
    }

    public function accessRules(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $data = parent::afterAction($action, $result);

        if (isset($data['data']) === false) {
            $data = [
                'code'  => 0,
                'data'  => $data,
                'error' => null,
            ];
        }

        $data['code']  = $data['code'] ?? 0;
        $data['error'] = $data['error'] ?? null;

        return $data;
    }
}

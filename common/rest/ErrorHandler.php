<?php

declare(strict_types=1);

namespace common\rest;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @param \Exception $exception
     *
     * @throws \yii\base\InvalidParamException
     */
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent  = false;
            $response->stream  = null;
            $response->data    = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        if (\in_array($response->format, [Response::FORMAT_JSON, Response::FORMAT_XML], true)) {
            $response->data = $this->convertExceptionToArray($exception);

            if ($exception instanceof HttpException) {
                $response->setStatusCode($exception->statusCode);
            } else {
                $response->setStatusCode(500);
            }
            $response->send();

            return;
        }

        parent::renderException($exception);
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function convertExceptionToArray($exception): array
    {
        $code     = \method_exists($exception, 'getCode') ? $exception->getCode() : -1;
        $response = [
            'code'  => $code ? : -1,
            'data'  => null,
            'error' => 'Error',
        ];

        if ($exception instanceof UserException || YII_DEBUG === true) {
            $response['error'] = ($exception instanceof Exception || $exception instanceof ErrorException) ? $exception->getName() : 'Exception';
            $response['data']  = $exception->getMessage();
        }

        if (YII_DEBUG) {
            $response['_file']  = $exception->getFile();
            $response['_line']  = $exception->getLine();
            $response['_trace'] = [];

            foreach ($exception->getTrace() as $i => $item) {
                $response['_trace'][$i] = $item;

                unset($response['_trace'][$i]['args']);
            }
        }

        return $response;
    }
}

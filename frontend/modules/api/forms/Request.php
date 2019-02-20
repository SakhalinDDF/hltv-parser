<?php

namespace api\forms;

use yii\base\Exception;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use common\models\Request as Record;

class Request extends Model
{
    public $url;

    /**
     * @var \common\models\Request
     */
    private $_record;

    public function __construct(Record $request, array $config = [])
    {
        $this->_record = $request;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['url'], 'required'],
            [['url'], 'url'],
        ];
    }

    public function save(): bool
    {
        if ($this->validate() === false) {
            $errors = $this->getFirstErrors();

            throw new BadRequestHttpException(\current($errors));
        }

        $transaction = \Yii::$app->getDb()->beginTransaction();
        $record      = $this->_record;

        try {
            $record->status = $record->status ?? Record::STATUS_NEW;
            $record->url    = $this->url;

            if ($record->save() === false) {
                throw new BadRequestHttpException();
            }

            $transaction->commit();
        } catch (Exception $exception) {
            $transaction->rollBack();

            $this->addErrors($record->getErrors());

            $errors = $this->getFirstErrors();

            throw new BadRequestHttpException(\current($errors) ? : $exception->getMessage(), $exception->getCode() ? : -1, $exception);
        }

        return true;
    }
}

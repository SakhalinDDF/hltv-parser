<?php

namespace api\actions\request;

use yii\base\Action;
use common\models\Request as Record;
use api\forms\Request as Form;

/**
 * @property \api\controllers\RequestController $controller
 */
class Create extends Action
{
    public function run()
    {
        $record = new Record();
        $form   = new Form($record);

        $form->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $form->save();

        return $record->id;
    }
}

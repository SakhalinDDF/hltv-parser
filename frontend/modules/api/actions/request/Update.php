<?php

namespace api\actions\request;

use yii\base\Action;
use api\forms\Request as Form;

/**
 * @property \api\controllers\RequestController $controller
 */
class Update extends Action
{
    public function run(int $id)
    {
        $record = $this->controller->findModel($id);
        $form   = new Form($record);

        $form->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $form->save();

        return true;
    }
}

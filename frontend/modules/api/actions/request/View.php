<?php

namespace api\actions\request;

use yii\base\Action;

/**
 * @property \api\controllers\RequestController $controller
 */
class View extends Action
{
    public function run(int $id)
    {
        $record = $this->controller->findModel($id);

        $record->parse();

        return $record;
    }
}

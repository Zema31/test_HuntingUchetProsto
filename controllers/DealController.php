<?php

namespace app\controllers;

use yii\rest\ActiveController;

class DealController extends ActiveController
{
    public $modelClass = 'app\models\Deal';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['cors'] = [
            'class' => \yii\filters\Cors::class,
        ];

        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update') {
            if (!$model) {
                throw new \yii\web\NotFoundHttpException("Сделка не существует");
            }
        }
    }
}

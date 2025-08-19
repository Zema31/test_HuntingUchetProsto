<?php

namespace app\controllers;

use yii\rest\ActiveController;

class ContactController extends ActiveController
{
    public $modelClass = 'app\models\Contact';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['cors'] = [
            'class' => \yii\filters\Cors::class,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update') {
            if (!$model) {
                throw new \yii\web\NotFoundHttpException("Контакт не существует");
            }
        }
    }
}

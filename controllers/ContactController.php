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
}

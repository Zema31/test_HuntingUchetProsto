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
}

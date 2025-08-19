<?php

namespace app\controllers;

use app\models\Contact;
use Yii;
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

    public function actions()
    {
        $actions = parent::actions();

        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update') {
            if (!$model) {
                throw new \yii\web\NotFoundHttpException("Сделка не существует");
            }
        }
    }

    public function actionAddContact($id)
    {
        $deal = $this->modelClass::findOne($id);
        if (!$deal) {
            throw new \yii\web\NotFoundHttpException("Сделка не существует");
        }

        $contactId = Yii::$app->request->post('contact_id');

        $contact = Contact::findOne($contactId);
        if (!$contact) {
            throw new \yii\web\NotFoundHttpException("Контакт не существует");
        }

        if (!$deal->getContacts()->where(['id' => $contactId])->exists()) {
            $deal->link('contacts', $contact);
        }

        Yii::$app->response->statusCode = 201;
        return ['status' => 'success', 'message' => 'Контакт добавлен к сделке'];
    }

    public function actionRemoveContact($id, $contactId)
    {
        $deal = $this->modelClass::findOne($id);
        if (!$deal) {
            throw new \yii\web\NotFoundHttpException("Сделка не существует");
        }
        $contact = Contact::findOne($contactId);

        if (!$contact) {
            throw new \yii\web\NotFoundHttpException("Контакт не существует");
        }

        if (!$deal->getContacts()->where(['id' => $contactId])->exists()) {
            throw new \yii\web\BadRequestHttpException("Контакт не прикреплен к этой сделке");
        }

        $deal->unlink('contacts', $contact, true);

        return ['status' => 'success', 'message' => 'Контакт удален из сделки'];
    }
}

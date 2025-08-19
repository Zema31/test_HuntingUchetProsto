<?php

namespace app\controllers;

use app\models\Contact;
use app\models\Deal;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Страница База знаний.
     *
     * @return string
     */
    public function actionThemes()
    {
        return $this->render('themes');
    }

    /**
     * Страница Магазин.
     *
     * @return string
     */
    public function actionShop()
    {
        $deals = Deal::find()->with('contacts')->all();
        $contacts = Contact::find()->with('deals')->all();

        return $this->render(
            'shop',
            ['deals' => $deals, 'contacts' => $contacts]
        );
    }

    public function actionTest()
    {
        Yii::info('Тестовый экшн вызван');

        // Простая проверка сохранения
        $model = new Contact();
        $model->name = 'Test';
        $model->surname = 'Test';

        if ($model->save()) {
            Yii::info('Тестовое сохранение успешно');
            return ['success' => true, 'id' => $model->id];
        } else {
            Yii::error('Тестовое сохранение failed: ' . print_r($model->errors, true));
            return ['success' => false, 'errors' => $model->errors];
        }
    }
}

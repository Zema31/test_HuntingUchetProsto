<?php

namespace app\controllers;

use app\models\Contact;
use app\models\Deal;
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
        // $dealsRaw = Deal::find()->all();
        // $deals = [];
        // foreach ($dealsRaw as $deal) {
        //     $deals[$deal->name] = [
        //         $deal->idText,
        //         $deal->nameText,
        //         $deal->sumText,
        //     ];
        // }

        // $contactsRaw = Contact::find()->all();
        // $contacts = [];
        // foreach ($contactsRaw as $contact) {
        //     $contacts[$contact->name] = [
        //         $contact->idText,
        //         $contact->nameText,
        //         $contact->surnameText,
        //     ];
        // }

        $deals = Deal::find()->all();
        $contacts = Contact::find()->all();

        return $this->render(
            'shop',
            ['deals' => $deals, 'contacts' => $contacts]
        );
    }
}

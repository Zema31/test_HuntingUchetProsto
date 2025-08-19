<?php

/** @var yii\web\View $this */
// В конфигурации или в начале приложения
Yii::debug('Registered routes: ' . print_r(Yii::$app->urlManager->rules, true));

use app\assets\ShopAsset;
use yii\helpers\Html;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;

ShopAsset::register($this);
$this->title = 'База данных магазина';
$this->params['breadcrumbs'][] = $this->title;

$dealsSection = [];
foreach ($deals as $deal) {
    $dealContacts = '';
    foreach ($deal->contacts as $contact) {
        $dealContacts .= 'id контакта: ' . $contact->id . ' | ' . $contact->name . " " . $contact->surname . "<br>";
    }
    $content = [
        'id сделки: ' . $deal->id,
        'Наименование: ' . $deal->name,
        'Сумма: ' . $deal->sum,
        'Контакты: <br>' . $dealContacts
    ];
    $label = $deal->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-deal" data-id="' . $deal->id . '">Редактировать</button>' . ' <button class="btn btn-sm btn-outline-danger delete-btn delete-deal" data-id="' . $deal->id . '">Удалить</button>';
    $dealsSection[] = [
        'label' => $label,
        'content' => $content,
        'encode' => false,
    ];
}

$contactsSection = [];
foreach ($contacts as $contact) {
    $contactDeals = '';
    foreach ($contact->deals as $deal) {
        $contactDeals .= 'id сделки: ' . $deal->id . ' | ' . $deal->name . '<br>';
    }
    $content = [
        'id контакта: ' . $contact->id,
        'Имя: ' . $contact->name,
        'Фамилия: ' . $contact->surname,
        'Сделки: <br>' . $contactDeals
    ];
    $label = $contact->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-contact" data-id="' . $contact->id . '">Редактировать</button>' . ' <button class="btn btn-sm btn-outline-danger delete-btn delete-contact" data-id="' . $contact->id . '">Удалить</button>';
    $contactsSection[] = [
        'label' => $label,
        'content' => $content,
        'encode' => false,
    ];
}

$items = [
    [
        'label' => 'Сделки <button class="btn btn-sm btn-outline-primary create-deal create-btn">Создать</button>',
        'content' => Accordion::widget(['items' => $dealsSection]),
        'options' => ['class' => 'my-accordion'],
        'encode' => false,
    ],
    [
        'label' => 'Контакты <button class="btn btn-sm btn-outline-primary create-contact create-btn">Создать</button>',
        'content' => Accordion::widget(['items' => $contactsSection]),
        'options' => ['class' => 'my-accordion'],
        'encode' => false,
    ]
];

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        База данных магазина
    </p>
    <?php
    echo Accordion::widget([
        'items' => $items,
        'options' => ['class' => 'my-accordion'],
    ]);

    // Модальное окно редактирования Контакта
    Modal::begin([
        'id' => 'editContactModal',
        'title' => 'Редактирование Контакта',
        'footer' => '
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
        <button type="button" class="btn btn-primary" id="saveContactBtn">Сохранить</button>
    ',
        'options' => ['tabindex' => '-1', 'aria-hidden' => 'true'],
        'dialogOptions' => ['class' => 'modal-dialog'],
    ]);

    $formContact = ActiveForm::begin([
        'id' => 'editContactForm',
        'enableAjaxValidation' => false,
    ]);
    ?>
    <input type="hidden" id="editContactId" name="id">

    <div class="mb-3">
        <label class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" id="editContactName">
    </div>

    <div class="mb-3">
        <label class="form-label">Фамилия</label>
        <input type="text" class="form-control" name="surname" id="editContactSurname">
    </div>

    <?php
    ActiveForm::end();
    Modal::end();
    ?>

    <?php
    // Модальное окно редактирования Сделки
    Modal::begin([
        'id' => 'editDealModal',
        'title' => 'Редактирование Сделки',
        'footer' => '
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
        <button type="button" class="btn btn-primary" id="saveDealBtn">Сохранить</button>
    ',
        'options' => ['tabindex' => '-1', 'aria-hidden' => 'true'],
        'dialogOptions' => ['class' => 'modal-dialog modal-lg'],
    ]);

    $formDeal = ActiveForm::begin([
        'id' => 'editDealForm',
        'enableAjaxValidation' => false,
    ]);
    ?>
    <input type="hidden" id="editDealId" name="id">

    <div class="mb-3">
        <label class="form-label">Наименование</label>
        <input type="text" class="form-control" name="name" id="editDealName">
    </div>

    <div class="mb-3">
        <label class="form-label">Сумма</label>
        <input type="num" class="form-control" name="sum" id="editDealSum">
    </div>

    <div class="mb-3 contact-section">
        <label class="form-label">Прикрепленные контакты</label>
        <div id="attachedContacts" class="border rounded p-2">
            <div class="text-center text-muted" id="noAttachedContactsMessage">
                Нет прикрепленных контактов
            </div>
            <div id="attachedContactsList" class="d-none">
            </div>
        </div>
    </div>

    <div class="mb-3 contact-section">
        <label class="form-label">Добавить контакт</label>
        <div id="possibleContacts" class="border rounded p-2">
            <div class="text-center text-muted" id="noPossibleContactsMessage">
                Нет возможных контактов
            </div>
            <div id="possibleContactsList" class="d-none">
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end();
    Modal::end();
    ?>

</div>

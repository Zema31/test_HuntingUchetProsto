<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;

$this->title = 'База данных магазина';
$this->params['breadcrumbs'][] = $this->title;

$dealsSection = [];
foreach ($deals as $deal) {
    $dealContacts = '';
    foreach ($deal->contacts as $contact) {
        $dealContacts .= 'id контакта: ' . $contact->id . ' | ' . $contact->name . " " . $contact->surname . "\n";
    }
    $content = [
        'id сделки: ' . $deal->id,
        'Наименование: ' . $deal->name,
        'Сумма: ' . $deal->sum,
        'Контакты: <br>' . $dealContacts
    ];
    $label = $deal->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-deal" data-id="' . $deal->id . '">Редактировать</button>' . ' <button class="btn btn-sm btn-outline-danger edit-btn delete-deal" data-id="' . $deal->id . '">Удалить</button>';
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
        $contactDeals .= 'id сделки: ' . $deal->id . ' | ' . $deal->name . "\n";
    }
    $content = [
        'id контакта: ' . $contact->id,
        'Имя: ' . $contact->name,
        'Фамилия: ' . $contact->surname,
        'Сделки: <br>' . $contactDeals
    ];
    $label = $contact->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-contact" data-id="' . $contact->id . '">Редактировать</button>' . ' <button class="btn btn-sm btn-outline-danger edit-btn delete-contact" data-id="' . $contact->id . '">Удалить</button>';
    $contactsSection[] = [
        'label' => $label,
        'content' => $content,
        'encode' => false,
    ];
}

$items = [
    [
        'label' => 'Сделки <button class="btn btn-sm btn-outline-primary edit-btn create-deal">Создать</button>',
        'content' => Accordion::widget(['items' => $dealsSection]),
        'options' => ['class' => 'my-accordion'],
        'encode' => false,
    ],
    [
        'label' => 'Контакты <button class="btn btn-sm btn-outline-primary edit-btn create-contact">Создать</button>',
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
        'dialogOptions' => ['class' => 'modal-dialog'],
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
    <?php
    ActiveForm::end();
    Modal::end();
    ?>

</div>

<script>
    let $document = $(document);

    $document.on('click', '.edit-contact', function() {
        $editContact = $(this).closest("button");
        const id = $editContact.data('id');

        $('#editContactForm')[0].reset();
        $('#editContactId').val(id);

        $.ajax({
            url: '/contact/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#editContactName').val(data.name);
                $('#editContactSurname').val(data.surname);
            },
            error: function(xhr, status, error) {
                alert('Ошибка загрузки данных контакта:' + error);
            },
            complete: function() {
                $('#editContactModal').modal('show');
            }
        });
    });

    $document.on('click', '.edit-deal', function() {
        $editDeal = $(this).closest("button");
        const id = $editDeal.data('id');

        $('#editDealForm')[0].reset();
        $('#editDealId').val(id);

        $.ajax({
            url: '/deal/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#editDealName').val(data.name);
                $('#editDealSum').val(data.sum);
            },
            error: function(xhr, status, error) {
                alert('Ошибка загрузки данных сделки:' + error);
            },
            complete: function() {
                $('#editDealModal').modal('show');
            }
        });
    });

    $document.on('click', '#saveContactBtn', function() {
        let id = null;
        if (typeof $editDeal !== 'undefined' && $editDeal.length > 0) {
            id = $editDeal.data('id');
        }

        const url = id ? '/contact/' + id : '/contact';
        const method = id ? 'PUT' : 'POST';

        const formData = $('#editContactForm').serialize();

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#editContactModal').modal('hide');
                alert('Контакт успешно сохранен');
                location.reload();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422 && xhr.responseJSON) {
                    alert('Ошибка валидации:\n' + xhr.responseJSON[0]['message']);
                } else {
                    alert('Ошибка сохранения:\n' + error);
                }
            },
        });
    });

    $document.on('click', '#saveDealBtn', function() {
        let id = null;
        if (typeof $editDeal !== 'undefined' && $editDeal.length > 0) {
            id = $editDeal.data('id');
        }
        const url = id ? '/deal/' + id : '/deal';
        const method = id ? 'PUT' : 'POST';

        const formData = $('#editDealForm').serialize();

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#editDealModal').modal('hide');
                alert('Сделка успешно сохранена');
                location.reload();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422 && xhr.responseJSON) {
                    alert('Ошибка валидации:\n' + xhr.responseJSON[0]['message']);
                } else {
                    alert('Ошибка сохранения:\n' + error);
                }
            },
        });
    });

    $document.on('click', '.delete-deal', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '/deal/' + id,
            method: 'DELETE',
            dataType: 'json',
            success: function(data) {
                alert('Сделка успешно удалена');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Ошибка удаления сделки:' + error);
            },
        });
    });

    $document.on('click', '.delete-contact', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '/contact/' + id,
            method: 'DELETE',
            dataType: 'json',
            success: function(data) {
                alert('Контакт успешно удален');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Ошибка удаления контакт:' + error);
            },
        });
    });

    $document.on('click', '.create-deal', function() {
        $('#editDealForm')[0].reset();
        $('#editDealModal').modal('show');
    });

    $document.on('click', '.create-contact', function() {
        $('#editContactForm')[0].reset();
        $('#editContactModal').modal('show');
    });
</script>
<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\Accordion;

$this->title = 'База данных магазина';
$this->params['breadcrumbs'][] = $this->title;

$dealsSection = [];
foreach ($deals as $deal) {
    $content = [
        'id сделки: ' . $deal->id,
        'Наименование: ' . $deal->name,
        'Сумма: ' . $deal->sum,
    ];
    $label = $deal->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-deal" data-id="' . $deal->id . '">Редактировать</button>';
    $dealsSection[] = [
        'label' => $label,
        'content' => $content,
        'encode' => false,
    ];
}

$contactsSection = [];
foreach ($contacts as $contact) {
    $content = [
        'id контакта: ' . $contact->id,
        'Имя: ' . $contact->name,
        'Фамилия: ' . $contact->surname,
    ];
    $label = $contact->name . ' <button class="btn btn-sm btn-outline-primary edit-btn edit-contact" data-id="' . $contact->id . '">Редактировать</button>';
    $contactsSection[] = [
        'label' => $label,
        'content' => $content,
        'encode' => false,
    ];
}

$items = [
    [
        'label' => 'Сделки',
        'content' => Accordion::widget(['items' => $dealsSection]),
        'options' => ['class' => 'my-accordion'],
    ],
    [
        'label' => 'Контакты',
        'content' => Accordion::widget(['items' => $contactsSection]),
        'options' => ['class' => 'my-accordion'],
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
    ?>

    <!-- Модальное окно редактирования Контакта -->
    <div class="modal fade" id="editContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование Контакта</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContactForm">
                        <!-- Уникальные ID для элементов контакта -->
                        <input type="hidden" id="editContactId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" class="form-control" name="name" id="editContactName">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Фамилия</label>
                            <input type="text" class="form-control" name="surname" id="editContactSurname">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="saveContactBtn">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования Сделки -->
    <div class="modal fade" id="editDealModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Исправленный заголовок -->
                    <h5 class="modal-title">Редактирование Сделки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDealForm">
                        <!-- Уникальные ID для элементов сделки -->
                        <input type="hidden" id="editDealId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Наименование</label>
                            <input type="text" class="form-control" name="name" id="editDealName">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Сумма</label>
                            <input type="text" class="form-control" name="sum" id="editDealSum">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="saveDealBtn">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Используем делегирование событий для динамических элементов
    $(document).on('click', '.edit-contact', function() {
        const id = $(this).data('id');
        console.log("Opening contact modal for ID:", id);

        // Сброс и настройка формы контакта
        $('#editContactForm')[0].reset();
        $('#editContactId').val(id);

        // Здесь можно добавить AJAX-запрос для загрузки данных
        $('#editContactModal').modal('show');
    });

    $(document).on('click', '.edit-deal', function() {
        const id = $(this).data('id');
        console.log("Opening deal modal for ID:", id);

        // Сброс и настройка формы сделки
        $('#editDealForm')[0].reset();
        $('#editDealId').val(id);

        // Здесь можно добавить AJAX-запрос для загрузки данных
        $('#editDealModal').modal('show');
    });
</script>


<!-- // // Обработчик сохранения
// $('#saveBtn').click(function() {
// const formData = $('#editContactForm').serializeArray();
// const data = {};
// $.each(formData, function(_, field) {
// data[field.name] = field.value;
// });

// $.post('/site/update-item', data, function(response) {
// if (response.success) {
// $('#editContactModal').modal('hide');
// location.reload(); // Обновляем страницу
// } else {
// alert('Ошибка: ' + response.message);
// }
// });
// });

// Загрузка данных
// $.get('/site/get-item', {
// id
// }, function(data) {
// if (data.success) {
// $('#editName').val(data.model.name);
// $('#editSurname').val(data.model.surname);
// $('#editContactModal').modal('show');
// }
// }); -->
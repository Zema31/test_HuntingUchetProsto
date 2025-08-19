let $document = $(document);

let allContacts = [];
let contactsLoaded = false;

$document.on('click', '.edit-contact', function () {
    $editContact = $(this).closest("button");
    const id = $editContact.data('id');

    $('#editContactForm')[0].reset();
    $('#editContactId').val(id);

    $.ajax({
        url: '/contact/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#editContactName').val(data.name);
            $('#editContactSurname').val(data.surname);
        },
        error: function (xhr, status, error) {
            alert('Ошибка загрузки данных контакта:' + error);
        },
        complete: function () {
            $('#editContactModal').modal('show');
        }
    });
});

$document.on('click', '.edit-deal', function () {
    $editDeal = $(this).closest("button");
    const id = $editDeal.data('id');

    $('#editDealForm')[0].reset();
    $('#editDealId').val(id);

    $('.contact-section').show();

    $.ajax({
        url: '/deal/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#editDealName').val(data.name);
            $('#editDealSum').val(data.sum);

            updateContactsLists(data.contacts);
        },
        error: function (xhr, status, error) {
            alert('Ошибка загрузки данных сделки:' + error);
        },
        complete: function () {
            $('#editDealModal').modal('show');
        }
    });
});

$document.on('click', '#saveContactBtn', function () {
    let id = null;
    if (typeof $editContact !== 'undefined' && $editContact.length > 0) {
        id = $editContact.data('id');
    }

    const url = id ? '/contact/' + id : '/contact';
    const method = id ? 'PUT' : 'POST';

    const formData = $('#editContactForm').serialize();

    $.ajax({
        url: url,
        type: method,
        data: formData,
        success: function (response) {
            $('#editContactModal').modal('hide');
            location.reload();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422 && xhr.responseJSON) {
                alert('Ошибка валидации:\n' + xhr.responseJSON[0]['message']);
            } else {
                alert('Ошибка сохранения:\n' + error);
            }
        },
    });
});

$document.on('click', '#saveDealBtn', function () {
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
        success: function (response) {
            $('#editDealModal').modal('hide');
            location.reload();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422 && xhr.responseJSON) {
                alert('Ошибка валидации:\n' + xhr.responseJSON[0]['message']);
            } else {
                alert('Ошибка сохранения:\n' + error);
            }
        },
    });
});

$document.on('click', '.delete-deal', function () {
    const id = $(this).data('id');
    $.ajax({
        url: '/deal/' + id,
        method: 'DELETE',
        dataType: 'json',
        success: function (data) {
            location.reload();
        },
        error: function (xhr, status, error) {
            alert('Ошибка удаления сделки:' + error);
        },
    });
});

$document.on('click', '.delete-contact', function () {
    const id = $(this).data('id');
    $.ajax({
        url: '/contact/' + id,
        method: 'DELETE',
        dataType: 'json',
        success: function (data) {
            location.reload();
        },
        error: function (xhr, status, error) {
            alert('Ошибка удаления контакт:' + error);
        },
    });
});

$document.on('click', '.create-deal', function () {
    $('#editDealForm')[0].reset();
    $('.contact-section').hide();
    $('#editDealModal').modal('show');
});

$document.on('click', '.create-contact', function () {
    $('#editContactForm')[0].reset();
    $('#editContactModal').modal('show');
});

function updateContactsList(contacts, contactListId, noContactsMessageId, editBtnType) {
    const contactsList = $(contactListId);
    const noContactsMessage = $(noContactsMessageId);

    contactsList.empty();

    if (contacts.length === 0) {
        noContactsMessage.removeClass('d-none');
        contactsList.addClass('d-none');
        return;
    }

    noContactsMessage.addClass('d-none');
    contactsList.removeClass('d-none');

    contacts.forEach(function (contact) {
        const contactItem = $('<div class="contact-item d-flex justify-content-between align-items-center mb-2 p-2 border-bottom"></div>');
        const contactInfo = $('<div></div>').text(contact.id + ': ' + contact.name + contact.surname);

        let editBtn;
        if (editBtnType == 'delete') {
            editBtn = $('<button type="button" class="btn btn-sm btn-danger">Удалить</button>');
        } else {
            editBtn = $('<button type="button" class="btn btn-sm btn-success">Добавить</button>');
        }
        editBtn.data('contact-id', contact.id);
        editBtn.on('click', function () {
            if (editBtnType == 'delete') {
                deleteContactFromDeal(contact.id);
            } else {
                addContactToDeal(contact.id);
            }
        });

        contactItem.append(contactInfo).append(editBtn);
        contactsList.append(contactItem);
    });
}

function loadContacts(callback) {
    if (contactsLoaded) {
        if (callback) callback();
        return;
    }

    $.ajax({
        url: '/contact', // URL к вашему action
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            allContacts = data;
            contactsLoaded = true;
        },
        error: function (xhr, status, error) {
            location.reload();
        },
        complete: function () {
            if (callback) callback();
        }
    });
}

async function filterContacts(attachedContacts) {
    await new Promise(resolve => {
        loadContacts(resolve);
    });
    console.log(attachedContacts);
    console.log(allContacts);
    const attachedContactIds = attachedContacts.map(contact => contact.id);
    return allContacts.filter(contact =>
        !attachedContactIds.includes(contact.id)
    );
}

function deleteContactFromDeal(contactId) {
    const dealId = $('#editDealId').val();
    console.log(contactId);
    console.log(dealId);
    if (!confirm('Вы уверены, что хотите удалить контакт из сделки?')) {
        return;
    }
    $.ajax({
        url: '/deal/' + dealId + '/contacts/' + contactId,
        method: 'DELETE',
        data: {
            _csrf: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $.ajax({
                url: '/deal/' + dealId,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    updateContactsLists(data.contacts);
                }
            });
        },
        error: function (xhr, status, error) {
            alert('Ошибка при удалении контакта: ' + error);
        }
    });
}

function addContactToDeal(contactId) {
    const dealId = $('#editDealId').val();
    console.log(contactId);
    console.log(dealId);
    $.ajax({
        url: '/deal/' + dealId + '/contacts',
        method: 'POST',
        data: {
            contact_id: contactId,
        },
        success: function (response) {
            $.ajax({
                url: '/deal/' + dealId,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    updateContactsLists(data.contacts);
                }
            });
        }
    });
}

async function updateContactsLists(contacts) {
    let possibleContacts = await filterContacts(contacts || []);
    updateContactsList(contacts || [], '#attachedContactsList', '#noAttachedContactsMessage', 'delete');
    updateContactsList(possibleContacts || [], '#possibleContactsList', '#noPossibleContactsMessage', 'add');
}
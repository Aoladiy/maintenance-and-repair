$(document).ready(function () {
    var name = getUrlParameter('name');
    var inventory_number = getUrlParameter('inventory_number');
    var data = {
        name: name,
        inventory_number: inventory_number,
    };
    var modalBody = $('#equipmentModalBody');
    var modalContent = showEquipment(data);
    modalBody.html(modalContent);
    if (data.name && data.inventory_number) {
        $('#equipmentModal').modal('show')
            .on('hidden.bs.modal', function () {
            window.location.replace(window.location.pathname);
        });
    }
    // Вызов функции при загрузке страницы
    loadEquipment();

    // Вызов функции каждый час
    setInterval(function () {
        loadSites();
    }, 3600000); // 3600000 миллисекунд - это 1 час
});
$(document).on('click', '.equipment-details-btn', function () {
    var data = $(this).data('item');
    var modalBody = $('#equipmentModalBody');
    var modalContent = showEquipment(data);
    modalBody.html(modalContent);
});
$(document).on('click', '.edit-equipment-btn', function () {
    var equipmentId = $(this).data('item-id');
    $.ajax({
        url: base + 'equipment/' + equipmentId, // URL для получения данных о элементе
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_equipment_name_input').val(response.name);
            $('#edit_inventory_number_input').val(response.inventory_number);
            $('#edit_equipment_id_input').val(equipmentId);
            $('#editEquipmentModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    var errorMessage = document.getElementById('EquipmentUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.create-item-btn', function () {
    var errorMessage = document.getElementById('EquipmentCreateError');
    var site_id = document.getElementById('parent_id').value
    $('#site_id_input').val(site_id);
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.delete-equipment-btn', function () {
    var equipmentId = $(this).data('item-id');
    if (confirm("Вы точно уверены, что хотите удалить это оборудование?")) {

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            url: base + 'equipment/' + equipmentId + '/delete',
            type: 'DELETE',
            success: function (response) {
                loadEquipment();
            },
            error: function (xhr, status, error) {
                alert(xhr.responseJSON.message)
                console.error(error);
            }
        });
    }
});

function loadEquipment() {
    const target = $('#root');
    let id = window.location.pathname.split("/").pop();
    $.ajax({
        url: base + 'equipment/site/' + id + '/all',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var html = '';
                $.each(response, function (index, item) {
                    var disabledClass = item.has_nodes ? '' : ' disabled';

                    var itemHtml = `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-start align-items-center">
                                <div id="notification-icon_${item.id}">
                                <div class="notification-icon me-3">
                                    <div class="spinner-grow" role="status">
                                        <span class="visually-hidden">Загрузка...</span>
                                    </div>
                                </div>
                                </div>
                                <a href="${base}nodes/equipment/${item.id}">
                                    <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${item.id}" aria-expanded="false">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </button>
                                </a>
                                <div class="d-flex align-items-center flex-grow-1">
                                    <button class="btn btn-secondary me-2 equipment-details-btn flex-grow-1" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#equipmentModal">
                                        <span>${item.name}</span>
                                    </button>
                                </div>
                                <button class="btn btn-secondary edit-equipment-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editEquipmentModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger ms-2 delete-equipment-btn" data-item-id="${item.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <ul class="list-group collapse mt-2" id="item_${item.id}">
                            </ul>
                        </li>`;
                    html += itemHtml;
                });
                target.html(html);
                target.collapse('show');
            } else {
                target.html('<p>No items found.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

function showEquipment(data) {
    var html = '';
    html += '<p><strong>Название:</strong> ' + (data.name || '') + '</p>';
    html += '<p><strong>Инвентарный номер:</strong> ' + (data.inventory_number || '') + '</p>';
    return html;
}

function editEquipment() {
    var formData = $('#editEquipmentForm').serialize();
    var itemId = $('#edit_equipment_id_input').val();

    // Получить HTML всех потомков элемента
    var childrenHTML = $('#item_' + itemId).html();

    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'equipment/' + itemId + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            var disabledClass = response.has_nodes ? '' : ' disabled';
            // Обработка успешного редактирования элемента, если необходимо
            $('#editEquipmentModal').modal('hide');

            // Найти соответствующий элемент списка на странице по его ID
            var listEquipment = $('#item_' + itemId).closest('li.list-group-item');

            // Собрать HTML-код для обновленного элемента
            var updatedEquipmentHtml = `
                <li class="list-group-item">
                    <div class="d-flex justify-content-start align-items-center">
                        <div id="notification-icon_${response.id}">
                        <div class="notification-icon me-3">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>
                        </div>
                        <a href="${base}nodes/equipment/${response.id}">
                            <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${response.id}" aria-expanded="false">
                                <i class="fa-solid fa-caret-right"></i>
                            </button>
                        </a>
                        <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-secondary me-2 item-details-btn flex-grow-1" data-item='${JSON.stringify(response)}' data-bs-toggle="modal" data-bs-target="#equipmentModal">
                            <span>${response.name}</span>
                        </button>
                        </div>
                        <button class="btn btn-secondary edit-equipment-btn" data-item-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editEquipmentModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger ms-2 delete-equipment-btn" data-item-id="${response.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <ul class="list-group collapse mt-2" id="item_${response.id}">
                        ${childrenHTML} <!-- Вставить HTML всех потомков -->
                    </ul>
                </li>`;

            // Заменить содержимое элемента на обновленные данные
            listEquipment.replaceWith(updatedEquipmentHtml);
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('EquipmentUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

function createEquipment() {
    var formData = $('#createEquipmentForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'equipment/store',
        type: 'POST',
        data: formData,
        success: function (response) {
            loadEquipment();
            // loadEquipment(equipment_id); // Загружаем дочерние элементы для участка по equipment_id
            $('#createEquipmentForm').trigger('reset'); // Очищаем форму создания
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('EquipmentCreateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

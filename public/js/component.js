$(document).ready(function () {
    // Вызов функции при загрузке страницы
    loadComponents();

    // Вызов функции каждый час
    setInterval(function () {
        loadSites();
    }, 3600000); // 3600000 миллисекунд - это 1 час
});
$(document).on('click', '.component-details-btn', function () {
    var data = $(this).data('item');
    var modalBody = $('#componentModalBody');
    var modalContent = showComponent(data);
    modalBody.html(modalContent);
});
$(document).on('click', '.edit-component-btn', function () {
    var componentId = $(this).data('item-id');
    $.ajax({
        url: base + 'components/' + componentId, // URL для получения данных о элементе
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_component_name_input').val(response.name);
            $('#edit_vendor_code_input').val(response.vendor_code);
            $('#edit_amount_input').val(response.amount);
            $('#edit_component_id_input').val(componentId);
            $('#edit_unit_input').empty(); // Очищаем <select> перед заполнением
            fillUnitSelect('#edit_unit_input', response.unit_id); // Заполняем <select> значениями
            $('#editComponentModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    var errorMessage = document.getElementById('ComponentUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.create-item-btn', function () {
    $('#unit_input').empty(); // Очищаем <select> перед заполнением
    fillUnitSelect('#unit_input'); // Заполняем <select> значениями
    var errorMessage = document.getElementById('ComponentCreateError');
    var node_id = document.getElementById('parent_id').value
    $('#node_id_input').val(node_id);
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.delete-component-btn', function () {
    var componentId = $(this).data('item-id');
    if (confirm("Вы точно уверены, что хотите удалить этот участок?")) {

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            url: base + 'components/' + componentId + '/delete',
            type: 'DELETE',
            success: function (response) {
                loadComponents();
            },
            error: function (xhr, status, error) {
                alert(xhr.responseJSON.message)
                console.error(error);
            }
        });
    }
});

function loadComponents() {
    const target = $('#root');
    let id = window.location.pathname.split("/").pop();
    $.ajax({
        url: base + 'components/node/' + id + '/all',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var html = '';
                $.each(response, function (index, item) {

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
                                <div class="d-flex align-items-center flex-grow-1">
                                    <button class="btn btn-secondary me-2 component-details-btn flex-grow-1" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#componentModal">
                                        <span>${item.name}</span>
                                    </button>
                                </div>
                                <button class="btn btn-secondary edit-component-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editComponentModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger ms-2 delete-component-btn" data-item-id="${item.id}">
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

function showComponent(data) {
    var html = '';
    html += '<p><strong>Название:</strong> ' + (data.name || '') + '</p>';
    html += '<p><strong>Vendor Code:</strong> ' + (data.vendor_code || '') + '</p>';
    html += '<p><strong>Amount:</strong> ' + (data.amount || '') + '</p>';
    html += '<p><strong>Unit:</strong> ' + (data.unit || '') + '</p>';
    return html;
}

function editComponent() {
    var formData = $('#editComponentForm').serialize();
    var itemId = $('#edit_component_id_input').val();

    // Получить HTML всех потомков элемента
    var childrenHTML = $('#item_' + itemId).html();

    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'components/' + itemId + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            // Обработка успешного редактирования элемента, если необходимо
            $('#editComponentModal').modal('hide');

            // Найти соответствующий элемент списка на странице по его ID
            var listComponent = $('#item_' + itemId).closest('li.list-group-item');

            // Собрать HTML-код для обновленного элемента
            var updatedComponentHtml = `
                <li class="list-group-item">
                    <div class="d-flex justify-content-start align-items-center">
                        <div id="notification-icon_${response.id}">
                        <div class="notification-icon me-3">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>
                        </div>
                        <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-secondary me-2 item-details-btn flex-grow-1" data-item='${JSON.stringify(response)}' data-bs-toggle="modal" data-bs-target="#componentModal">
                            <span>${response.name}</span>
                        </button>
                        </div>
                        <button class="btn btn-secondary edit-component-btn" data-item-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editComponentModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger ms-2 delete-component-btn" data-item-id="${response.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <ul class="list-group collapse mt-2" id="item_${response.id}">
                        ${childrenHTML} <!-- Вставить HTML всех потомков -->
                    </ul>
                </li>`;

            // Заменить содержимое элемента на обновленные данные
            listComponent.replaceWith(updatedComponentHtml);
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('ComponentUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

function createComponent() {
    var formData = $('#createComponentForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'components/store',
        type: 'POST',
        data: formData,
        success: function (response) {
            loadComponents();
            // loadComponents(component_id); // Загружаем дочерние элементы для участка по component_id
            $('#createComponentForm').trigger('reset'); // Очищаем форму создания
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('ComponentCreateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

function fillUnitSelect(unitInput, defaultUnitId) {
    $.ajax({
        url: base + 'units',
        type: 'GET',
        success: function(response) {
            var options = '';
            $.each(response, function(index, unit) {
                var value = unit.id !== null ? unit.id : '-';
                var name = unit.name !== null ? unit.name : '-';
                var selected = unit.id === defaultUnitId ? 'selected' : ''; // Определяем, выбран ли элемент
                options += '<option value="' + value + '" ' + selected + '>' + name + '</option>';
            });
            $(unitInput).append(options);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

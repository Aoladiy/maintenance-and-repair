let base = 'http://localhost:8000/';
$(document).ready(function () {
    // Вызов функции при загрузке страницы
    loadChildren(-1);

    // Вызов функции каждый час
    setInterval(function() {
        loadChildren(-1);
    }, 3600000); // 3600000 миллисекунд - это 1 час
});
// Функция для загрузки дочерних элементов с учетом оповещений и сохранения в localStorage
// Функция для предварительного заполнения формы редактирования элемента и открытия модального окна
$(document).on('click', '.edit-item-btn', function () {
    var itemId = $(this).data('item-id');
    $.ajax({
        url: base + 'items/' + itemId, // URL для получения данных о элементе
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_site_input').val(response.site);
            $('#edit_equipment_name_input').val(response.equipment_name);
            $('#edit_inventory_number_input').val(response.inventory_number);
            $('#edit_node_input').val(response.node);
            $('#edit_component_input').val(response.component);
            $('#edit_vendor_code_input').val(response.vendor_code);
            $('#edit_operation_input').val(response.operation);
            $('#edit_service_period_in_days_input').val(response.service_period_in_days);
            $('#edit_service_period_in_engine_hours_input').val(response.service_period_in_engine_hours);
            $('#edit_engine_hours_on_the_datetime_of_last_service_input').val(response.engine_hours_on_the_datetime_of_last_service);
            $('#edit_mileage_input').val(response.mileage);
            $('#edit_mileage_on_the_datetime_of_last_service_input').val(response.mileage_on_the_datetime_of_last_service);
            $('#edit_amount_input').val(response.amount);
            $('#edit_datetime_of_last_service_input').val(response.datetime_of_last_service);
            $('#edit_item_id_input').val(itemId);
            $('#editItemModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
            // Обработка ошибки, если необходимо
        }
    });
});


// Обновленный обработчик события для кнопки удаления элемента
$(document).on('click', '.delete-item-btn', function () {
    var itemId = $(this).data('item-id');
    if (confirm("Are you sure you want to delete this item?")) {

        $.ajax({
            url: base + 'items/' + itemId + '/delete',
            type: 'DELETE',
            success: function (response) {
                var parentId = response.parent_id;

                // Проверяем, равно ли значение parentId null
                if (parentId === null) {
                    parentId = -1; // Если parentId равно null, устанавливаем значение -1
                }

                loadChildren(parentId);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
});


// Обработчик события для кнопок создания нового элемента
$(document).on('click', '.create-item-btn', function () {
    var parent_id = $(this).data('parent-id');
    $('#parent_id_input').val(parent_id);
});

// Обработчик события для кнопок деталей элемента
$(document).on('click', '.item-details-btn', function () {
    var data = $(this).data('item');
    var modalBody = $('#itemModalBody');
    var modalContent = generateModalContent(data);
    modalBody.html(modalContent);
});

// Обработчик события для кнопок вложенных элементов
$(document).on('click', '.toggle-btn', function () {
    var itemId = $(this).data('id');
    var target = $('#item_' + itemId);

    if (target.children().length === 0) {
        loadChildren(itemId);
    } else {
        target.collapse('toggle');
    }
});

// Функция для загрузки дочерних элементов
function loadChildren(itemId) {
    if (itemId == null) {
        itemId = 0;
    }

    var target = itemId === -1 ? $('#root') : $('#item_' + itemId);

    $.ajax({
        url: base + 'items/' + itemId + '/children/',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var html = '';
                var promises = []; // Массив промисов для запросов оповещений

                $.each(response, function (index, item) {
                    var disabledClass = item.has_children ? '' : ' disabled';

                    var itemHtml = `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-start align-items-center">
                                <div id="notification-icon_${item.id}">
                                <div class="notification-icon me-3">
                                    <i class="fa-regular fa-bell"></i>
                                </div>
                                </div>
                                <button class="btn btn-primary toggle-btn${disabledClass} me-2" data-id="${item.id}" aria-expanded="false">
                                    <i class="fa-solid fa-caret-right"></i>
                                </button>
                                <div class="d-flex align-items-center flex-grow-1">
                                    <button class="btn btn-info me-2 item-details-btn flex-grow-1" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#itemModal">
                                        <span>${getItemDescription(item)}</span>
                                    </button>
                                </div>
                                <button class="btn btn-success ms-auto create-item-btn" data-parent-id="${item.id}" data-bs-toggle="modal" data-bs-target="#createItemModal">
                                    Add
                                </button>
                                <button class="btn btn-warning ms-2 edit-item-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editItemModal">
                                    Edit
                                </button>
                                <button class="btn btn-danger ms-2 delete-item-btn" data-item-id="${item.id}">
                                    Delete
                                </button>
                            </div>
                            <ul class="list-group collapse mt-2" id="item_${item.id}">
                            </ul>
                        </li>`;
                    html += itemHtml;

                    // Если элемент имеет parent_id = null, добавляем запрос оповещений в массив промисов
                    if (item.parent_id === null) {
                        promises.push(fetchAlerts(item.id));
                    }
                });

                // После добавления всех элементов в HTML
                target.html(html);
                target.collapse('show');
                if (localStorage.getItem('combinedAlerts')) {
                    displayAlerts();
                }

                if (itemId === -1) {
                    // Выполняем все промисы запросов оповещений асинхронно
                    Promise.all(promises)
                        .then(function (alerts) {
                            // Объединяем полученные оповещения в один массив
                            var combinedAlerts = [].concat.apply([], alerts);

                            // Сохраняем объединенные оповещения в localStorage
                            localStorage.setItem('combinedAlerts', JSON.stringify(combinedAlerts));

                            // Отображаем оповещения только при наличии combinedAlerts
                            if (combinedAlerts.length > 0) {
                                displayAlerts(); // функция отображения оповещений
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                }


                // Вызываем функцию для обработки события открытия/закрытия списка
                handleToggleBtnClick();
            } else {
                target.html('<p>No items found.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}



// Функция для получения оповещений для конкретного элемента и возврата промиса
function fetchAlerts(itemId) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: base + 'items/' + itemId + '/alerts',
            type: 'GET',
            dataType: 'json',
            success: function(alertResponse) {
                resolve(alertResponse);
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}

// Функция для генерации контента модального окна подробностей
function generateModalContent(data) {
    var html = '';
    console.log("Ancestors before processing:", data.ancestors);
    if (data.ancestors && data.ancestors.length > 0) {
        html += '<p><strong>Address from Root:</strong> ';
        var addressParts = data.ancestors.map(function (item) {
            return getItemDescription(item);
        });
        // Добавляем текущий элемент в адрес в конце
        addressParts.push(getItemDescription(data));
        html += addressParts.join(' > ');
        html += '</p>';
    } else {
        // Если нет предков, просто показываем текущий элемент в качестве адреса
        html += '<p><strong>Address:</strong> ' + (data.site ? data.site : (data.equipment_name ? data.equipment_name : (data.inventory_number ? data.inventory_number : (data.node ? data.node : (data.component ? data.component : 'Не найдено названия'))))) + '</p>';
    }
    html += '<p><strong>Site:</strong> ' + data.site + '</p>';
    html += '<p><strong>Equipment Name:</strong> ' + data.equipment_name + '</p>';
    html += '<p><strong>Inventory Number:</strong> ' + data.inventory_number + '</p>';
    html += '<p><strong>Node:</strong> ' + data.node + '</p>';
    html += '<p><strong>Component:</strong> ' + data.component + '</p>';
    html += '<p><strong>Vendor Code:</strong> ' + data.vendor_code + '</p>';
    html += '<p><strong>Operation:</strong> ' + data.operation + '</p>';
    html += '<p><strong>Service Period (Days):</strong> ' + data.service_period_in_days + '</p>';
    html += '<p><strong>Service Period (Engine Hours):</strong> ' + data.service_period_in_engine_hours + '</p>';
    html += '<p><strong>Service Period (Engine Hours) on the datetime of last service:</strong> ' + data.engine_hours_on_the_datetime_of_last_service + '</p>';
    html += '<p><strong>Mileage:</strong> ' + data.mileage + '</p>';
    html += '<p><strong>Mileage on the datetime of last service:</strong> ' + data.mileage_on_the_datetime_of_last_service + '</p>';
    html += '<p><strong>Amount:</strong> ' + data.amount + '</p>';
    html += '<p><strong>Datetime of last service:</strong> ' + data.datetime_of_last_service + '</p>';
    html += '<p><strong>Parent ID:</strong> ' + data.parent_id + '</p>';
    return html;
}

// Функция для отправки данных нового элемента на сервер
function createItem() {
    var parent_id = $('#parent_id_input').val(); // Получаем значение parent_id из скрытого поля

    // Проверяем, равно ли значение parent_id null
    if (parent_id === null || parent_id === '') {
        parent_id = -1; // Если parent_id равно null, устанавливаем значение -1
    }

    var formData = $('#createItemForm').serialize();
    $.ajax({
        url: base + 'items/create',
        type: 'POST',
        data: formData,
        success: function (response) {
            loadChildren(parent_id); // Загружаем дочерние элементы с учетом parent_id
            $('#createItemForm').trigger('reset'); // Очищаем форму создания
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


// Функция для отправки данных редактирования элемента на сервер
function editItem() {
    var formData = $('#editItemForm').serialize();
    var itemId = $('#edit_item_id_input').val();

    // Получить HTML всех потомков элемента
    var childrenHTML = $('#item_' + itemId).html();

    $.ajax({
        url: base + 'items/' + itemId + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            // Обработка успешного редактирования элемента, если необходимо
            $('#editItemModal').modal('hide');

            // Найти соответствующий элемент списка на странице по его ID
            var listItem = $('#item_' + itemId).closest('li.list-group-item');

            // Собрать HTML-код для обновленного элемента
            var updatedItemHtml = `
                <li class="list-group-item">
                    <div class="d-flex justify-content-start align-items-center">
                        <div id="notification-icon_${response.id}">
                        <div class="notification-icon me-3">
                            <i class="fa-regular fa-bell"></i>
                        </div>
                        </div>
                        <button class="btn btn-primary toggle-btn${response.has_children ? '' : ' disabled'} me-2" data-id="${response.id}" aria-expanded="false">
                            <i class="fa-solid fa-caret-right"></i>
                        </button>
                        <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-info me-2 item-details-btn flex-grow-1" data-item='${JSON.stringify(response)}' data-bs-toggle="modal" data-bs-target="#itemModal">
                            <span>${getItemDescription(response)}</span>
                        </button>
                        </div>
                        <button class="btn btn-success ms-auto create-item-btn" data-parent-id="${response.id}" data-bs-toggle="modal" data-bs-target="#createItemModal">
                            Add
                        </button>
                        <button class="btn btn-warning ms-2 edit-item-btn" data-item-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editItemModal">
                            Edit
                        </button>
                        <button class="btn btn-danger ms-2 delete-item-btn" data-item-id="${response.id}">
                            Delete
                        </button>
                    </div>
                    <ul class="list-group collapse mt-2" id="item_${response.id}">
                        ${childrenHTML} <!-- Вставить HTML всех потомков -->
                    </ul>
                </li>`;

            // Заменить содержимое элемента на обновленные данные
            listItem.replaceWith(updatedItemHtml);

            if (localStorage.getItem('combinedAlerts')) {
                displayAlerts();
            }

            handleToggleBtnClick();
        },
        error: function (xhr, status, error) {
            console.error(error);
            // Обработка ошибки, если необходимо
        }
    });
}
function getItemDescription(item) {
    if (item.site) {
        return item.site;
    } else if (item.equipment_name) {
        if (item.inventory_number) {
            return item.equipment_name + ' (Инвентарный номер: ' + item.inventory_number + ')';
        }
        return item.equipment_name;
    } else if (item.node) {
        return item.node;
    } else if (item.component) {
        return item.component;
    } else {
        return '';
    }
}

function handleToggleBtnClick() {
    $('.toggle-btn').on('click', function () {
        var $nextLevel = $(this).parent().next('.collapse'); // Выбираем следующий уровень вложенности
        var icon = $(this).find('i.fa-solid');

        if ($nextLevel.hasClass('show')) {
            icon.removeClass('fa-caret-down').addClass('fa-caret-right');
        } else {
            icon.removeClass('fa-caret-right').addClass('fa-caret-down');
        }
    });
}

// Функция для определения и отображения оповещений
function displayAlerts() {
    // Получаем combinedAlerts из localStorage
    var combinedAlerts = JSON.parse(localStorage.getItem('combinedAlerts'));

    // Проверяем, есть ли оповещения для отображения
    if (combinedAlerts.length > 0) {
        // Проходим по всем элементам, для которых есть оповещения
        combinedAlerts.forEach(function(combinedAlert) {
            // Получаем id элемента и количество оповещений
            var itemId = combinedAlert.id;
            var alerts = combinedAlert.alerts;

            // Получаем элемент по id
            var $notificationIcon = $('#notification-icon_' + itemId);

            // Обновляем оповещения в соответствующем элементе
            if ($notificationIcon.length > 0) {
                if (alerts > 0) {
                    $notificationIcon.html(`
                        <div class="notification-icon me-3">
                        <span class="badge">${alerts}</span>
                        <i class="fa-regular fa-bell"></i>
                        </div>
                    `);
                } else {
                    $notificationIcon.html(`
                        <div class="notification-icon me-3">
                        <i class="fa-regular fa-bell"></i>
                        </div>
                    `);
                }
            }
        });
    }
}

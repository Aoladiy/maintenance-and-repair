$(document).ready(function () {
    var name = getUrlParameter('name');
    var data = {
        name: name,
    };
    var modalBody = $('#nodeModalBody');
    var modalContent = showNode(data);
    modalBody.html(modalContent);
    if (data.name) {
        $('#nodeModal').modal('show')
            .on('hidden.bs.modal', function () {
                window.location.replace(window.location.pathname);
            });
    }
    // Вызов функции при загрузке страницы
    loadNodes();

    // Вызов функции каждый час
    setInterval(function () {
        loadSites();
    }, 3600000); // 3600000 миллисекунд - это 1 час
});
$(document).on('click', '.node-details-btn', function () {
    var data = $(this).data('item');
    var modalBody = $('#nodeModalBody');
    var modalContent = showNode(data);
    modalBody.html(modalContent);
});
$(document).on('click', '.edit-node-btn', function () {
    var nodeId = $(this).data('item-id');
    $.ajax({
        url: base + 'nodes/' + nodeId, // URL для получения данных о элементе
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_node_name_input').val(response.name);
            $('#edit_node_id_input').val(nodeId);
            $('#editNodeModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    var errorMessage = document.getElementById('NodeUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.create-item-btn', function () {
    var errorMessage = document.getElementById('NodeCreateError');
    var equipment_id = document.getElementById('parent_id').value
    $('#equipment_id_input').val(equipment_id);
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.delete-node-btn', function () {
    var nodeId = $(this).data('item-id');
    if (confirm("Вы точно уверены, что хотите удалить этот узел?")) {

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            url: base + 'nodes/' + nodeId + '/delete',
            type: 'DELETE',
            success: function (response) {
                loadNodes();
            },
            error: function (xhr, status, error) {
                alert(xhr.responseJSON.message)
                console.error(error);
            }
        });
    }
});

function loadNodes() {
    const target = $('#root');
    let id = window.location.pathname.split("/").pop();
    $.ajax({
        url: base + 'nodes/equipment/' + id + '/all',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var html = '';
                $.each(response, function (index, item) {
                    var disabledClass = item.has_components ? '' : ' disabled';

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
                                <a href="${base}components/node/${item.id}">
                                    <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${item.id}" aria-expanded="false">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </button>
                                </a>
                                <div class="d-flex align-items-center flex-grow-1">
                                    <button class="btn btn-secondary me-2 node-details-btn flex-grow-1" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#nodeModal">
                                        <span>${item.name}</span>
                                    </button>
                                </div>
                                <button class="btn btn-secondary edit-node-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editNodeModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-secondary ms-2 edit-serviceable-btn" data-item-id="${item.id}" data-item-type="${item.class_name}" data-bs-toggle="modal" data-bs-target="#editServiceableModal">
                                    <i class="bi bi-wrench"></i>
                                </button>
                                <button class="btn btn-secondary ms-2 edit-alertable-btn" data-item-id="${item.id}" data-item-type="${item.class_name}" data-bs-toggle="modal" data-bs-target="#editAlertableModal">
                                    <i class="bi bi-bell"></i>
                                </button>
                                <button class="btn btn-danger ms-2 delete-node-btn" data-item-id="${item.id}">
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

function showNode(data) {
    var html = '';
    html += '<p><strong>Название:</strong> ' + (data.name || '') + '</p>';
    return html;
}

function editNode() {
    var formData = $('#editNodeForm').serialize();
    var itemId = $('#edit_node_id_input').val();

    // Получить HTML всех потомков элемента
    var childrenHTML = $('#item_' + itemId).html();

    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'nodes/' + itemId + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            var disabledClass = response.has_components ? '' : ' disabled';
            // Обработка успешного редактирования элемента, если необходимо
            $('#editNodeModal').modal('hide');

            // Найти соответствующий элемент списка на странице по его ID
            var listNode = $('#item_' + itemId).closest('li.list-group-item');

            // Собрать HTML-код для обновленного элемента
            var updatedNodeHtml = `
                <li class="list-group-item">
                    <div class="d-flex justify-content-start align-items-center">
                        <div id="notification-icon_${response.id}">
                        <div class="notification-icon me-3">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>
                        </div>
                        <a href="${base}components/node/${item.id}">
                            <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${response.id}" aria-expanded="false">
                                <i class="fa-solid fa-caret-right"></i>
                            </button>
                        </a>
                        <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-secondary me-2 node-details-btn flex-grow-1" data-item='${JSON.stringify(response)}' data-bs-toggle="modal" data-bs-target="#nodeModal">
                            <span>${response.name}</span>
                        </button>
                        </div>
                        <button class="btn btn-secondary edit-node-btn" data-item-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editNodeModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-secondary ms-2 edit-serviceable-btn" data-item-id="${response.id}" data-item-type="${response.class_name}" data-bs-toggle="modal" data-bs-target="#editServiceableModal">
                            <i class="bi bi-wrench"></i>
                        </button>
                        <button class="btn btn-secondary ms-2 edit-alertable-btn" data-item-id="${response.id}" data-item-type="${response.class_name}" data-bs-toggle="modal" data-bs-target="#editAlertableModal">
                            <i class="bi bi-bell"></i>
                        </button>
                        <button class="btn btn-danger ms-2 delete-node-btn" data-item-id="${response.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <ul class="list-group collapse mt-2" id="item_${response.id}">
                        ${childrenHTML} <!-- Вставить HTML всех потомков -->
                    </ul>
                </li>`;

            // Заменить содержимое элемента на обновленные данные
            listNode.replaceWith(updatedNodeHtml);
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('NodeUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

function createNode() {
    var formData = $('#createNodeForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'nodes/store',
        type: 'POST',
        data: formData,
        success: function (response) {
            loadNodes();
            // loadNodes(node_id); // Загружаем дочерние элементы для участка по node_id
            $('#createNodeForm').trigger('reset'); // Очищаем форму создания
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('NodeCreateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

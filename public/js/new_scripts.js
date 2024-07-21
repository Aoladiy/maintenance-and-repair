const base = 'http://localhost:8000/';
$(document).ready(function () {
    // Вызов функции при загрузке страницы
    loadSites();

    // Вызов функции каждый час
    setInterval(function () {
        loadSites();
    }, 3600000); // 3600000 миллисекунд - это 1 час
});
$(document).on('click', '.site-details-btn', function () {
    var data = $(this).data('item');
    var modalBody = $('#siteModalBody');
    var modalContent = showSite(data);
    modalBody.html(modalContent);
});
$(document).on('click', '.edit-site-btn', function () {
    var siteId = $(this).data('item-id');
    $.ajax({
        url: base + 'sites/' + siteId, // URL для получения данных о элементе
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response)
            // Заполнение полей формы данными полученными из сервера
            $('#edit_name_input').val(response.name);
            $('#edit_site_id_input').val(siteId);
            $('#editSiteModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    var errorMessage = document.getElementById('SiteUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.create-site-btn', function () {
    var errorMessage = document.getElementById('ItemCreateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});
$(document).on('click', '.delete-site-btn', function () {
    var siteId = $(this).data('item-id');
    if (confirm("Вы точно уверены, что хотите удалить этот участок?")) {

        $.ajax({
            url: base + 'sites/' + siteId + '/delete',
            type: 'DELETE',
            success: function (response) {
                loadSites();
            },
            error: function (xhr, status, error) {
                alert(xhr.responseJSON.message)
                console.error(error);
            }
        });
    }
});

function loadSites() {
    const target = $('#root');
    $.ajax({
        url: base + 'sites',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var html = '';
                $.each(response, function (index, item) {
                    var disabledClass = item.has_equipment ? '' : ' disabled';

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
                                <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${item.id}" aria-expanded="false">
                                    <i class="fa-solid fa-caret-right"></i>
                                </button>
                                <div class="d-flex align-items-center flex-grow-1">
                                    <button class="btn btn-secondary me-2 site-details-btn flex-grow-1" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#siteModal">
                                        <span>${item.name}</span>
                                    </button>
                                </div>
                                <button class="btn btn-secondary ms-auto create-item-btn" data-parent-id="${item.id}" data-bs-toggle="modal" data-bs-target="#createSiteModal">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <button class="btn btn-secondary ms-2 edit-site-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editSiteModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger ms-2 delete-site-btn" data-item-id="${item.id}">
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

function showSite(data) {
    var html = '';
    var address = data.name || 'Не найдено названия';
    html += '<p><strong>Адрес:</strong> ' + address + '</p>';
    html += '<p><strong>Название:</strong> ' + (data.name || '') + '</p>';
    return html;
}

function editSite() {
    var formData = $('#editSiteForm').serialize();
    var itemId = $('#edit_site_id_input').val();

    // Получить HTML всех потомков элемента
    var childrenHTML = $('#item_' + itemId).html();

    $.ajax({
        url: base + 'sites/' + itemId + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            var disabledClass = response.has_equipment ? '' : ' disabled';
            // Обработка успешного редактирования элемента, если необходимо
            $('#editSiteModal').modal('hide');

            // Найти соответствующий элемент списка на странице по его ID
            var listSite = $('#item_' + itemId).closest('li.list-group-item');

            // Собрать HTML-код для обновленного элемента
            var updatedSiteHtml = `
                <li class="list-group-item">
                    <div class="d-flex justify-content-start align-items-center">
                        <div id="notification-icon_${response.id}">
                        <div class="notification-icon me-3">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>
                        </div>
                        <button class="btn btn-secondary toggle-btn${disabledClass} me-2" data-id="${response.id}" aria-expanded="false">
                            <i class="fa-solid fa-caret-right"></i>
                        </button>
                        <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-secondary me-2 item-details-btn flex-grow-1" data-item='${JSON.stringify(response)}' data-bs-toggle="modal" data-bs-target="#siteModal">
                            <span>${response.name}</span>
                        </button>
                        </div>
                        <button class="btn btn-secondary ms-auto create-site-btn" data-parent-id="${response.id}" data-bs-toggle="modal" data-bs-target="#createSiteModal">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                        <button class="btn btn-secondary ms-2 edit-site-btn" data-item-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editSiteModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger ms-2 delete-site-btn" data-item-id="${response.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <ul class="list-group collapse mt-2" id="item_${response.id}">
                        ${childrenHTML} <!-- Вставить HTML всех потомков -->
                    </ul>
                </li>`;

            // Заменить содержимое элемента на обновленные данные
            listSite.replaceWith(updatedSiteHtml);

            handleToggleBtnClick();
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('SiteUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

function createSite() {
    var formData = $('#createSiteForm').serialize();
    $.ajax({
        url: base + 'sites/store',
        type: 'POST',
        data: formData,
        success: function (response) {
            loadSites();
            // loadEquipment(site_id); // Загружаем дочерние элементы для участка по site_id
            $('#createSiteForm').trigger('reset'); // Очищаем форму создания
        },
        error: function (xhr, status, error) {
            var errorMessage = document.getElementById('SiteCreateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

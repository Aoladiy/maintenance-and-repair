<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tree View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <button class="btn btn-success mb-2" data-parent-id="0" data-bs-toggle="modal" data-bs-target="#createItemModal">
        Create Root Item
    </button>
    <ul class="list-group">
        @foreach ($items as $item)
            <li class="list-group-item">
                <div class="d-flex justify-content-start align-items-center">
                    <button class="btn btn-primary toggle-btn {{ $item->has_children ? '' : 'disabled' }} me-2"
                            data-id="{{ $item->id }}" aria-expanded="false">
                        Load Children
                    </button>
                    <span class="ms-2">
                        @if(isset($item->site))
                            {{ $item->site }}
                        @elseif(isset($item->equipment_name))
                            {{ $item->equipment_name }}
                        @elseif(isset($item->inventory_number))
                            {{ $item->inventory_number }}
                        @elseif(isset($item->node))
                            {{ $item->node }}
                        @elseif(isset($item->component))
                            {{ $item->component }}
                        @else
                            нужно, чтобы отобразилось здесь
                        @endif
                    </span>
                    <button class="btn btn-success ms-auto create-item-btn"
                            data-parent-id="{{ $item->id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#createItemModal">
                        Add
                    </button>
                    <button class="btn btn-warning ms-2 edit-item-btn"
                            data-item-id="{{$item->id}}"
                            data-bs-toggle="modal"
                            data-bs-target="#editItemModal">
                        Edit
                    </button>
                    <button class="btn btn-info ms-2 item-details-btn"
                            data-item='{{ json_encode($item) }}'
                            data-bs-toggle="modal"
                            data-bs-target="#itemModal">
                        Show Details
                    </button>
                    <button class="btn btn-danger ms-2 delete-item-btn" data-item-id="{{$item->id}}">
                        Delete
                    </button>
                </div>
                <ul class="list-group collapse mt-2" id="item_{{ $item->id }}">

                </ul>
            </li>
        @endforeach
    </ul>
</div>


<!-- Модальное окно просмотра подробностей -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Item Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="itemModalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Create New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createItemForm">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id_input">
                    <div class="mb-3">
                        <label for="equipment_name_input" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="equipment_name_input" name="equipment_name">
                    </div>
                    <div class="mb-3">
                        <label for="site_input" class="form-label">Site</label>
                        <input type="text" class="form-control" id="site_input" name="site">
                    </div>
                    <div class="mb-3">
                        <label for="inventory_number_input" class="form-label">Inventory Number</label>
                        <input type="text" class="form-control" id="inventory_number_input" name="inventory_number">
                    </div>
                    <div class="mb-3">
                        <label for="node_input" class="form-label">Node</label>
                        <input type="text" class="form-control" id="node_input" name="node">
                    </div>
                    <div class="mb-3">
                        <label for="component_input" class="form-label">Component</label>
                        <input type="text" class="form-control" id="component_input" name="component">
                    </div>
                    <div class="mb-3">
                        <label for="vendor_code_input" class="form-label">Vendor Code</label>
                        <input type="text" class="form-control" id="vendor_code_input" name="vendor_code">
                    </div>
                    <div class="mb-3">
                        <label for="operation_input" class="form-label">Operation</label>
                        <input type="text" class="form-control" id="operation_input" name="operation">
                    </div>
                    <div class="mb-3">
                        <label for="service_period_in_days_input" class="form-label">Service Period (Days)</label>
                        <input type="number" class="form-control" id="service_period_in_days_input"
                               name="service_period_in_days">
                    </div>
                    <div class="mb-3">
                        <label for="service_period_in_engine_hours_input" class="form-label">Service Period (Engine
                            Hours)</label>
                        <input type="number" class="form-control" id="service_period_in_engine_hours_input"
                               name="service_period_in_engine_hours">
                    </div>
                    <div class="mb-3">
                        <label for="mileage_input" class="form-label">Mileage</label>
                        <input type="number" class="form-control" id="mileage_input" name="mileage">
                    </div>
                    <div class="mb-3">
                        <label for="amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount_input" name="amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="createItem()">Create</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editItemForm">
                    @csrf
                    <input type="hidden" name="item_id" id="edit_item_id_input">
                    <!-- Поля для редактирования элемента -->
                    <div class="mb-3">
                        <label for="edit_equipment_name_input" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="edit_equipment_name_input" name="equipment_name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_site_input" class="form-label">Site</label>
                        <input type="text" class="form-control" id="edit_site_input" name="site">
                    </div>
                    <div class="mb-3">
                        <label for="edit_inventory_number_input" class="form-label">Inventory Number</label>
                        <input type="text" class="form-control" id="edit_inventory_number_input"
                               name="inventory_number">
                    </div>
                    <div class="mb-3">
                        <label for="edit_node_input" class="form-label">Node</label>
                        <input type="text" class="form-control" id="edit_node_input" name="node">
                    </div>
                    <div class="mb-3">
                        <label for="edit_component_input" class="form-label">Component</label>
                        <input type="text" class="form-control" id="edit_component_input" name="component">
                    </div>
                    <div class="mb-3">
                        <label for="edit_vendor_code_input" class="form-label">Vendor Code</label>
                        <input type="text" class="form-control" id="edit_vendor_code_input" name="vendor_code">
                    </div>
                    <div class="mb-3">
                        <label for="edit_operation_input" class="form-label">Operation</label>
                        <input type="text" class="form-control" id="edit_operation_input" name="operation">
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_period_in_days_input" class="form-label">Service Period (Days)</label>
                        <input type="number" class="form-control" id="edit_service_period_in_days_input"
                               name="service_period_in_days">
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_period_in_engine_hours_input" class="form-label">Service Period (Engine
                            Hours)</label>
                        <input type="number" class="form-control" id="edit_service_period_in_engine_hours_input"
                               name="service_period_in_engine_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_mileage_input" class="form-label">Mileage</label>
                        <input type="number" class="form-control" id="edit_mileage_input" name="mileage">
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="edit_amount_input" name="amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editItem()">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (необходим для работы collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Функция для предварительного заполнения формы редактирования элемента и открытия модального окна
    $(document).on('click', '.edit-item-btn', function () {
        var itemId = $(this).data('item-id');
        $.ajax({
            url: 'items/' + itemId, // URL для получения данных о элементе
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Заполнение полей формы данными полученными из сервера
                $('#edit_equipment_name_input').val(response.equipment_name);
                $('#edit_site_input').val(response.site);
                $('#edit_inventory_number_input').val(response.inventory_number);
                $('#edit_node_input').val(response.node);
                $('#edit_component_input').val(response.component);
                $('#edit_vendor_code_input').val(response.vendor_code);
                $('#edit_operation_input').val(response.operation);
                $('#edit_service_period_in_days_input').val(response.service_period_in_days);
                $('#edit_service_period_in_engine_hours_input').val(response.service_period_in_engine_hours);
                $('#edit_mileage_input').val(response.mileage);
                $('#edit_amount_input').val(response.amount);
                // Добавьте остальные поля редактирования аналогичным образом
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
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: 'items/' + itemId + '/delete',
                type: 'DELETE',
                data: {
                    _token: csrfToken
                },
                success: function (response) {
                    // Выполните загрузку дочерних элементов для элемента с id=parent_id удаленного элемента
                    var parentId = response.parent_id;
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
            itemId = 0
        }
        var target = $('#item_' + itemId);

        $.ajax({
            url: '/items/' + itemId + '/children/',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    var html = '';
                    $.each(response, function (index, item) {
                        var disabledClass = item.has_children ? '' : ' disabled';
                        var itemHtml = `
    <li class="list-group-item">
        <div class="d-flex justify-content-start align-items-center">
            <button class="btn btn-primary toggle-btn${disabledClass} me-2" data-id="${item.id}" aria-expanded="false">
                Load Children
            </button>
            <span class="ms-2">${item.site ? item.site :
                            item.equipment_name ? item.equipment_name :
                                item.inventory_number ? item.inventory_number :
                                    item.node ? item.node :
                                        item.component ? item.component :
                                            'нужно, чтобы отобразилось здесь'}</span>
            <button class="btn btn-success ms-auto create-item-btn" data-parent-id="${item.id}" data-bs-toggle="modal" data-bs-target="#createItemModal">
                Add
            </button>
            <button class="btn btn-warning ms-2 edit-item-btn" data-item-id="${item.id}" data-bs-toggle="modal" data-bs-target="#editItemModal">
                Edit
            </button>
            <button class="btn btn-info ms-2 item-details-btn" data-item='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#itemModal">
                Show Details
            </button>
            <button class="btn btn-danger ms-2 delete-item-btn" data-item-id="${item.id}">
                Delete
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

    // Функция для генерации контента модального окна подробностей
    function generateModalContent(data) {
        var html = '';
        html += '<p><strong>Equipment Name:</strong> ' + data.equipment_name + '</p>';
        html += '<p><strong>Site:</strong> ' + data.site + '</p>';
        html += '<p><strong>Inventory Number:</strong> ' + data.inventory_number + '</p>';
        html += '<p><strong>Node:</strong> ' + data.node + '</p>';
        html += '<p><strong>Component:</strong> ' + data.component + '</p>';
        html += '<p><strong>Vendor Code:</strong> ' + data.vendor_code + '</p>';
        html += '<p><strong>Operation:</strong> ' + data.operation + '</p>';
        html += '<p><strong>Service Period (Days):</strong> ' + data.service_period_in_days + '</p>';
        html += '<p><strong>Service Period (Engine Hours):</strong> ' + data.service_period_in_engine_hours + '</p>';
        html += '<p><strong>Mileage:</strong> ' + data.mileage + '</p>';
        html += '<p><strong>Amount:</strong> ' + data.amount + '</p>';
        html += '<p><strong>Parent ID:</strong> ' + data.parent_id + '</p>';
        return html;
    }

    // Функция для отправки данных нового элемента на сервер
    function createItem() {
        var formData = $('#createItemForm').serialize();
        $.ajax({
            url: 'items/create',
            type: 'POST',
            data: formData,
            success: function (response) {
                var parent_id = $('#parent_id_input').val();
                loadChildren(parent_id);
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
        $.ajax({
            url: 'items/' + itemId + '/update',
            type: 'PATCH',
            data: formData,
            success: function (response) {
                // Обработка успешного редактирования элемента, если необходимо
                $('#editItemModal').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Обработка ошибки, если необходимо
            }
        });
    }
</script>


</body>
</html>

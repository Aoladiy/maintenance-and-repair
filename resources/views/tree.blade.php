<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f66700a1b.js" crossorigin="anonymous"></script>
    <style>
        .notification-icon {
            position: relative;
            display: inline-block;
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
        }

        .fa-bell {
            font-size: 24px;
            color: #333;
        }

    </style>
</head>
<body>
<div class="container">
    <p class="mt-4">
        <a href="{{route('scheduled-maintenances.index')}}" class="btn btn-success">План ТОиР</a>
    </p>
</div>

<!-- Модальное окно просмотра подробностей -->
@include('./modals/modal_details')

<!-- Модальное окно для создания нового элемента -->
@include('./modals/modal_create')

<!-- Модальное окно для создания новой записи о техническом обслуживании -->
@include('./modals/modal_maintenance_create')

{{--<!-- Модальное окно для редактирования элемента -->--}}
@include('./modals/modal_edit')

<div class="container mt-4">
    <button class="btn btn-success mb-2 create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createItemModal">
        Create Root Item
    </button>
    <ul class="list-group" id="root">
    </ul>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (необходим для работы collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Основные скрипты -->
<script src="{{asset('js/scripts.js')}}"></script>


</body>
</html>

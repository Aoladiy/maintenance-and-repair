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
        <a href="{{route('index')}}" class="btn btn-secondary">На главную</a>
    </p>
</div>
<div class="container">
    <p class="mt-4">
        <a href="{{route('scheduled-maintenances.index')}}" class="btn btn-secondary">План ТОиР</a>
    </p>
</div>
<div class="container">
    <p class="mt-4">
        <a href="{{route('scheduled-purchases.index')}}" class="btn btn-secondary">План Закупок</a>
    </p>
</div>
<div class="container mt-4">
    <button class="btn btn-secondary mb-2 create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createSiteModal">
        Создать участок
    </button>
    <div>@yield('address')</div>
    <ul class="list-group" id="root">
    </ul>
</div>
@yield('modals')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (необходим для работы collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Основные скрипты -->
<script src="{{asset('js/new_scripts.js')}}"></script>
@yield('scripts')


</body>
</html>

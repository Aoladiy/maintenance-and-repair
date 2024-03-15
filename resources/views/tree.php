<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Модальное окно просмотра подробностей -->
<?php include './modals/modal_details.php'; ?>

<!-- Модальное окно для создания нового элемента -->
<?php include './modals/modal_create.php'; ?>

<!-- Модальное окно для редактирования элемента -->
<?php include './modals/modal_edit.php'; ?>

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
<script src="../js/scripts.js"></script>


</body>
</html>

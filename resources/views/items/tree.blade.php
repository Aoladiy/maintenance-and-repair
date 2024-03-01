<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <ul class="list-group">
        @foreach ($items as $item)
            <li class="list-group-item">
                <div class="d-flex justify-content-start align-items-center">
                    <button class="btn btn-primary toggle-btn {{ $item->has_children ? '' : 'disabled' }} me-2"
                            data-id="{{ $item->id }}" aria-expanded="false">
                        Load Children
                    </button>
                    <span class="ms-2">{{ $item->equipment_name }}</span>
                </div>
                <ul class="list-group collapse mt-2" id="item_{{ $item->id }}">

                </ul>
            </li>
        @endforeach
    </ul>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (необходим для работы collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Добавляем обработчик события для кнопок вложенных элементов
    $(document).on('click', '.toggle-btn', function () {
        var itemId = $(this).data('id');
        var target = $('#item_' + itemId);

        // Проверяем, были ли уже загружены дочерние элементы
        if (target.children().length === 0) {
            // Если нет, делаем AJAX запрос
            $.ajax({
                url: '/items/' + itemId + '/children/', // Укажите URL для загрузки дочерних элементов
                type: 'GET',
                dataType: 'json', // Укажите тип данных, которые ожидаете от сервера
                success: function (response) {
                    if (response.length > 0) {
                        // Преобразуем данные в HTML и добавляем их во вложенный список
                        var html = '';
                        $.each(response, function (index, item) {
                            html += '<li class="list-group-item">';
                            html += '<div class="d-flex justify-content-start align-items-center">';
                            html += '<button class="btn btn-primary toggle-btn' + (item.has_children ? '' : ' disabled') + ' me-2" data-id="' + item.id + '" aria-expanded="false">';
                            html += 'Load Children';
                            html += '</button>';
                            html += '<span class="ms-2">' + item.equipment_name + '</span>';
                            html += '</div>';
                            html += '<ul class="list-group collapse mt-2" id="item_' + item.id + '">';
                            html += '</ul>';
                            html += '</li>';
                        });
                        target.html(html);
                        target.collapse('show'); // Показываем вложенный список
                    } else {
                        // Если ответ пустой, можно добавить сообщение или просто вывести сообщение об отсутствии элементов
                        target.html('<p>No items found.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            // Если дочерние элементы уже загружены, просто показываем/скрываем вложенный список
            target.collapse('toggle');
        }
    });
</script>


</body>
</html>

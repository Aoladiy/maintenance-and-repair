<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createMaintenanceModal" tabindex="-1" aria-labelledby="createMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMaintenanceModalLabel">Create New Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createMaintenanceForm">
                    <input type="hidden" name="item_id" id="item_id_input">
                    <input type="hidden" name="username" id="username" value="will be accessed through get parameters">
                    <!-- Элемент для отображения ошибки -->
                    <p id="MaintenanceCreateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <div class="mb-3">
                        <label for="datetime_of_service" class="form-label">Maintenance date</label>
                        <input type="datetime-local" class="form-control" id="datetime_of_service"
                               name="datetime_of_service" onchange="checkDateTimeOfService()">
                    </div>
                    <div class="mb-3">
                        <label for="comment_input" class="form-label">Comment</label>
                        <textarea type="text" class="form-control" id="comment_input" name="comment" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" id="createButton" onclick="createMaintenance()" disabled>Create</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Функция для получения и установки даты обслуживания
    function setMaintenanceDate() {
        // Отправляем запрос AJAX на сервер
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost:8000/maintenance/time', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Парсим ответ сервера
                var response = JSON.parse(xhr.responseText);
                if (response && response.datetime_of_service && response.datetime_of_service.date) {
                    // Получаем значение datetime_of_service из ответа
                    var serverDate = response.datetime_of_service.date;
                    // Обрезаем строку даты до первых 16 символов, чтобы получить дату и время без миллисекунд и временной зоны
                    var formattedDate = serverDate.slice(0, 16).replace(' ', 'T');
                    // Устанавливаем отформатированную дату и время в поле формы
                    document.getElementById('datetime_of_service').value = formattedDate;
                    // Проверяем, заполнено ли поле datetime_of_service
                    checkDateTimeOfService();
                } else {
                    alert('Failed to get maintenance date.');
                }
            }
        };
        xhr.send();
    }

    // Событие, срабатывающее при открытии модального окна
    document.getElementById('createMaintenanceModal').addEventListener('show.bs.modal', function () {
        // Вызываем функцию для установки даты обслуживания при открытии модального окна
        setMaintenanceDate();
    });

    // Функция для проверки заполнения поля datetime_of_service
    function checkDateTimeOfService() {
        var datetimeOfService = document.getElementById('datetime_of_service').value;
        var createButton = document.getElementById('createButton');
        // Если поле заполнено, активируем кнопку "Create", иначе деактивируем
        if (datetimeOfService) {
            createButton.disabled = false;
        } else {
            createButton.disabled = true;
        }
    }
</script>

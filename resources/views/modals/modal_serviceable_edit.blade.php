<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editServiceableModal" tabindex="-1" aria-labelledby="editServiceableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceableModalLabel">Редактировать сервисные данные</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editServiceableForm">
                    <p id="ServiceableUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="serviceable_id" id="edit_serviceable_id_input">
                    <input type="hidden" name="serviceable_type" id="edit_serviceable_type_input">
                    <div class="mb-3">
                        <label for="edit_service_duration_in_seconds_input" class="form-label">Продолжительность обслуживания в секундах</label>
                        <input type="number" class="form-control" id="edit_service_duration_in_seconds_input" name="service_duration_in_seconds">
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_period_in_days_input" class="form-label">Частота обслуживания в днях</label>
                        <input type="number" class="form-control" id="edit_service_period_in_days_input"
                               name="service_period_in_days">
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_period_in_engine_hours_input" class="form-label">Частота обслуживания в моточасах</label>
                        <input type="number" class="form-control" id="edit_service_period_in_engine_hours_input"
                               name="service_period_in_engine_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_period_in_mileage_input" class="form-label">Частота обслуживания в пробеге</label>
                        <input type="number" class="form-control" id="edit_service_period_in_mileage_input"
                               name="service_period_in_mileage">
                    </div>
                    <div class="mb-3">
                        <label for="edit_engine_hours_by_the_datetime_of_last_service_input" class="form-label">Моточасы на момент последнего обслуживания</label>
                        <input type="number" class="form-control" id="edit_engine_hours_by_the_datetime_of_last_service_input"
                               name="engine_hours_by_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_mileage_by_the_datetime_of_last_service_input" class="form-label">Пробег на момент последнего обслуживания</label>
                        <input type="number" class="form-control" id="edit_mileage_by_the_datetime_of_last_service_input" name="mileage_by_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_datetime_of_last_service_input" class="form-label">Дата и время последнего обслуживания</label>
                        <input type="datetime-local" class="form-control" id="edit_datetime_of_last_service_input" name="datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_datetime_of_next_service_input" class="form-label">Дата и время следующего обслуживания</label>
                        <input type="datetime-local" class="form-control" id="edit_datetime_of_next_service_input" name="datetime_of_next_service">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editServiceable()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

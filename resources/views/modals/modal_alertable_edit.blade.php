<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editAlertableModal" tabindex="-1" aria-labelledby="editAlertableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlertableModalLabel">Редактировать данные о предупреждениях</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAlertableForm">
                    <p id="AlertableUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="alertable_id" id="edit_alertable_id_input">
                    <input type="hidden" name="alertable_type" id="edit_alertable_type_input">
                    <div class="mb-3">
                        <label for="edit_alert_in_advance_in_hours_input" class="form-label">За сколько часов предупреждать</label>
                        <input type="number" class="form-control" id="edit_alert_in_advance_in_hours_input" name="alert_in_advance_in_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_in_advance_in_engine_hours_input" class="form-label">За сколько моточасов предупреждать</label>
                        <input type="number" class="form-control" id="edit_alert_in_advance_in_engine_hours_input" name="alert_in_advance_in_engine_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_in_advance_in_mileage_input" class="form-label">За сколько пробега предупреждать</label>
                        <input type="number" class="form-control" id="edit_alert_in_advance_in_mileage_input" name="alert_in_advance_in_mileage">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_input" class="form-label">Актвно ли предупреждение</label>
                        <input type="checkbox" class="form-check-input" id="edit_alert_input" name="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editAlertable()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

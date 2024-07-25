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
                    <!-- Элемент для отображения ошибки -->
                    <p id="ItemUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="item_id" id="edit_item_id_input">
                    <!-- Поля для редактирования элемента -->
                    <div class="mb-3">
                        <label for="edit_site_input" class="form-label">Site</label>
                        <input type="text" class="form-control" id="edit_site_input" name="site">
                    </div>
                    <div class="mb-3">
                        <label for="edit_equipment_name_input" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="edit_equipment_name_input" name="equipment_name">
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
                        <textarea type="text" class="form-control" id="edit_component_input" name="component" rows="5"></textarea>
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
                        <label for="edit_service_duration_in_seconds_input" class="form-label">Service duration in seconds</label>
                        <input type="number" class="form-control" id="edit_service_duration_in_seconds_input" name="service_duration_in_seconds">
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
                        <label for="edit_engine_hours_on_the_datetime_of_last_service_input" class="form-label">Service Period (Engine
                            Hours) on the datetime of last service</label>
                        <input type="number" class="form-control" id="edit_engine_hours_on_the_datetime_of_last_service_input"
                               name="engine_hours_on_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_mileage_input" class="form-label">Mileage</label>
                        <input type="number" class="form-control" id="edit_mileage_input" name="mileage">
                    </div>
                    <div class="mb-3">
                        <label for="edit_mileage_on_the_datetime_of_last_service_input" class="form-label">Mileage on the datetime of last service</label>
                        <input type="number" class="form-control" id="edit_mileage_on_the_datetime_of_last_service_input" name="mileage_on_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="edit_amount_input" name="amount">
                    </div>
                    <div class="mb-3">
                        <label for="edit_datetime_of_last_service_input" class="form-label">Datetime of last service</label>
                        <input type="datetime-local" class="form-control" id="edit_datetime_of_last_service_input" name="datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_time_in_hours_input" class="form-label">Alert time in hours</label>
                        <input type="number" class="form-control" id="edit_alert_time_in_hours_input" name="alert_time_in_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_time_in_engine_hours_input" class="form-label">Alert time in engine hours</label>
                        <input type="number" class="form-control" id="edit_alert_time_in_engine_hours_input" name="alert_time_in_engine_hours">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_time_in_mileage_input" class="form-label">Alert time in mileage</label>
                        <input type="number" class="form-control" id="edit_alert_time_in_mileage_input" name="alert_time_in_mileage">
                    </div>
                    <div class="mb-3">
                        <label for="edit_alert_input" class="form-label">Alert</label>
                        <input type="checkbox" class="form-check-input" id="edit_alert_input" name="alert">
                    </div>
                    <div class="mb-3">
                        <label for="edit_unit_input" class="form-label">Unit</label>
                        <select class="form-control" id="edit_unit_input" name="unit_id">
                            <!-- Опции будут добавлены с помощью AJAX -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="editItem()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

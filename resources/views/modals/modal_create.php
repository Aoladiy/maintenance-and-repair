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
                    <input type="hidden" name="parent_id" id="parent_id_input">
                    <div class="mb-3">
                        <label for="site_input" class="form-label">Site</label>
                        <input type="text" class="form-control" id="site_input" name="site">
                    </div>
                    <div class="mb-3">
                        <label for="equipment_name_input" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="equipment_name_input" name="equipment_name">
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
                        <label for="engine_hours_on_the_datetime_of_last_service_input" class="form-label">Service Period (Engine
                            Hours) on the datetime of last service</label>
                        <input type="number" class="form-control" id="engine_hours_on_the_datetime_of_last_service_input"
                               name="engine_hours_on_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="mileage_input" class="form-label">Mileage</label>
                        <input type="number" class="form-control" id="mileage_input" name="mileage">
                    </div>
                    <div class="mb-3">
                        <label for="mileage_on_the_datetime_of_last_service_input" class="form-label">Mileage on the datetime of last service</label>
                        <input type="number" class="form-control" id="mileage_on_the_datetime_of_last_service_input" name="mileage_on_the_datetime_of_last_service">
                    </div>
                    <div class="mb-3">
                        <label for="amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount_input" name="amount">
                    </div>
                    <div class="mb-3">
                        <label for="datetime_of_last_service_input" class="form-label">Datetime of last service</label>
                        <input type="datetime-local" class="form-control" id="datetime_of_last_service_input" name="datetime_of_last_service">
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

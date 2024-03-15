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

<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-labelledby="editEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEquipmentModalLabel">Редактировать оборудование</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEquipmentForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="EquipmentUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="edit_equipment_id_input" id="edit_equipment_id_input">
                    <div class="mb-3">
                        <label for="edit_equipment_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_equipment_name_input" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_inventory_number_input" class="form-label">Инвентарный номер</label>
                        <input type="text" class="form-control" id="edit_inventory_number_input" name="inventory_number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editEquipment()">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

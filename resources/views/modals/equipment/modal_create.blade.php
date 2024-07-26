<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createEquipmentModal" tabindex="-1" aria-labelledby="createEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEquipmentModalLabel">Создать новое оборудование</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createEquipmentForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="EquipmentCreateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="site_id" id="site_id_input">
                    <div class="mb-3">
                        <label for="equipment_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="equipment_name_input" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="inventory_number_input" class="form-label">Инвентарный номер</label>
                        <input type="text" class="form-control" id="inventory_number_input" name="inventory_number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="createEquipment()">Создать</button>
            </div>
        </div>
    </div>
</div>

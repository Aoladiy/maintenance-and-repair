<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editComponentModal" tabindex="-1" aria-labelledby="editComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editComponentModalLabel">Редактировать деталь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editComponentForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="ComponentUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="id" id="edit_component_id_input">
                    <div class="mb-3">
                        <label for="edit_component_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_component_name_input" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_vendor_code_input" class="form-label">Vendor Code</label>
                        <input type="text" class="form-control" id="edit_vendor_code_input" name="vendor_code">
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="edit_amount_input" name="amount">
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editComponent()">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

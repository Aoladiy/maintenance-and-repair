<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editNodeModal" tabindex="-1" aria-labelledby="editNodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNodeModalLabel">Редактировать узел</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editNodeForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="NodeUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="id" id="edit_node_id_input">
                    <div class="mb-3">
                        <label for="edit_node_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_node_name_input" name="name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editNode()">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

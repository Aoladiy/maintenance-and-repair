<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createNodeModal" tabindex="-1" aria-labelledby="createNodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNodeModalLabel">Создать новый узел</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createNodeForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="NodeCreateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="equipment_id" id="equipment_id_input">
                    <div class="mb-3">
                        <label for="node_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="node_name_input" name="name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="createNode()">Создать</button>
            </div>
        </div>
    </div>
</div>

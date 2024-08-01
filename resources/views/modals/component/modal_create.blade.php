<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createComponentModal" tabindex="-1" aria-labelledby="createComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createComponentModalLabel">Создать новую деталь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createComponentForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="ComponentCreateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="node_id" id="node_id_input">
                    <div class="mb-3">
                        <label for="component_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="component_name_input" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="vendor_code_input" class="form-label">Vendor Code</label>
                        <input type="text" class="form-control" id="vendor_code_input" name="vendor_code">
                    </div>
                    <div class="mb-3">
                        <label for="amount_input" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount_input" name="amount">
                    </div>
                    <div class="mb-3">
                        <label for="unit_input" class="form-label">Unit</label>
                        <select class="form-control" id="unit_input" name="unit_id">
                            <!-- Опции будут добавлены с помощью AJAX -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="createComponent()">Создать</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для редактирования элемента -->
<div class="modal fade" id="editSiteModal" tabindex="-1" aria-labelledby="editSiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSiteModalLabel">Редактировать участок</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSiteForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="SiteUpdateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <input type="hidden" name="site_id" id="edit_site_id_input">
                    <!-- Поля для редактирования элемента -->
                    <div class="mb-3">
                        <label for="edit_name_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_name_input" name="name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="editSite()">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для создания нового элемента -->
<div class="modal fade" id="createSiteModal" tabindex="-1" aria-labelledby="createSiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSiteModalLabel">Создать новый участок</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createSiteForm">
                    <!-- Элемент для отображения ошибки -->
                    <p id="SiteCreateError" style="display: none; color: red; font-weight: bold;">Здесь будет сообщение об ошибке</p>
                    <div class="mb-3">
                        <label for="site_input" class="form-label">Название</label>
                        <input type="text" class="form-control" id="site_input" name="name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-secondary" onclick="createSite()">Создать</button>
            </div>
        </div>
    </div>
</div>

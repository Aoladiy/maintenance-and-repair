const base = 'http://maintenance-and-repair.local/';

function getUrlParameter(name) {
    name = name.replace(/\[/, '\\[').replace(/]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

$(document).on('click', '.edit-alertable-btn', function () {
    const alertable_id = $(this).data('item-id');
    const alertable_type = $(this).data('item-type');
    $.ajax({
        url: base + 'alert-characteristics/edit', // URL для получения данных о элементе
        type: 'post',
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        data: {alertable_id: alertable_id, alertable_type: alertable_type},
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_alertable_id_input').val(alertable_id);
            $('#edit_alertable_type_input').val(alertable_type);
            $('#edit_alert_in_advance_in_hours_input').val(response.alert_in_advance_in_hours);
            $('#edit_alert_in_advance_in_engine_hours_input').val(response.alert_in_advance_in_engine_hours);
            $('#edit_alert_in_advance_in_mileage_input').val(response.alert_in_advance_in_mileage);
            $('#edit_alert_input').prop('checked', response.alert);
            $('#editServiceableModalModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    const errorMessage = document.getElementById('AlertableUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});

function editAlertable() {
    const formData = $('#editAlertableForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'alert-characteristics' + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            // Обработка успешного редактирования элемента, если необходимо
            $('#editAlertableModal').modal('hide');
            $('#edit_alertable_id_input').val(response.alertable_id);
            $('#edit_alertable_type_input').val(response.alertable_type);
            $('#edit_alert_in_advance_in_hours_input').val(response.alert_in_advance_in_hours);
            $('#edit_alert_in_advance_in_engine_hours_input').val(response.alert_in_advance_in_engine_hours);
            $('#edit_alert_in_advance_in_mileage_input').val(response.alert_in_advance_in_mileage);
            $('#edit_alert_input').prop('checked', response.alert);
        },
        error: function (xhr, status, error) {
            const errorMessage = document.getElementById('AlertableUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

$(document).on('click', '.edit-serviceable-btn', function () {
    const serviceable_id = $(this).data('item-id');
    const serviceable_type = $(this).data('item-type');
    $.ajax({
        url: base + 'service-characteristics/edit', // URL для получения данных о элементе
        type: 'post',
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        data: {serviceable_id: serviceable_id, serviceable_type: serviceable_type},
        dataType: 'json',
        success: function (response) {
            // Заполнение полей формы данными полученными из сервера
            $('#edit_serviceable_id_input').val(serviceable_id);
            $('#edit_serviceable_type_input').val(serviceable_type);
            $('#edit_service_duration_in_seconds_input').val(response.service_duration_in_seconds);
            $('#edit_service_period_in_days_input').val(response.service_period_in_days);
            $('#edit_service_period_in_engine_hours_input').val(response.service_period_in_engine_hours);
            $('#edit_engine_hours_by_the_datetime_of_last_service_input').val(response.engine_hours_by_the_datetime_of_last_service);
            $('#mileage').val(response.mileage);
            $('#edit_mileage_by_the_datetime_of_last_service_input').val(response.mileage_by_the_datetime_of_last_service);
            $('#edit_datetime_of_last_service_input').val(response.datetime_of_last_service);
            $('#edit_datetime_of_next_service_input').val(response.datetime_of_next_service);
            $('#editServiceableModalModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    const errorMessage = document.getElementById('AlertableUpdateError');
    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
});

function editServiceable() {
    const formData = $('#editServiceableForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        url: base + 'service-characteristics' + '/update',
        type: 'PATCH',
        data: formData,
        success: function (response) {
            // Обработка успешного редактирования элемента, если необходимо
            $('#editServiceableModal').modal('hide');
            $('#edit_serviceable_id_input').val(serviceable_id);
            $('#edit_serviceable_type_input').val(serviceable_type);
            $('#edit_service_duration_in_seconds_input').val(response.service_duration_in_seconds);
            $('#edit_service_period_in_days_input').val(response.service_period_in_days);
            $('#edit_service_period_in_engine_hours_input').val(response.service_period_in_engine_hours);
            $('#edit_engine_hours_by_the_datetime_of_last_service_input').val(response.engine_hours_by_the_datetime_of_last_service);
            $('#mileage').val(response.mileage);
            $('#edit_mileage_by_the_datetime_of_last_service_input').val(response.mileage_by_the_datetime_of_last_service);
            $('#edit_datetime_of_last_service_input').val(response.datetime_of_last_service);
            $('#edit_datetime_of_next_service_input').val(response.datetime_of_next_service);
        },
        error: function (xhr, status, error) {
            const errorMessage = document.getElementById('ServiceAbleUpdateError');
            errorMessage.textContent = xhr.responseJSON.message;
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
            console.error(error);
        }
    });
}

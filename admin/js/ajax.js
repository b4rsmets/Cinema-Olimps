$(document).ready(function() {
    var $userRows = $('.user-row');
    var $panels = $('.panel');
    var $updateRoleForms = $('.update-role-form');
    var $infoAdmin = $('.info-admin');

    // Event delegation for admin/user buttons
    $userRows.on('click', '.btn-give-admin, .btn-remove-admin', function(evt) {
        evt.preventDefault();
        var $this = $(this);
        var userId = $this.data('user-id');
        var userRole = $this.data('user-role');
        var newRole = (userRole === 'user') ? 'admin' : 'user';
        var newRoleText = (newRole === 'admin') ? 'Админ' : 'Пользователь';
        var $userRow = $this.closest('.user-row');

        $.ajax({
            type: "POST",
            url: "/admin/ajax/update-role.php",
            data: {
                user_id: userId,
                user_role: newRole
            },
            success: function(response) {
                $userRow.find('.user-role').html(newRoleText);
                var $btn = $userRow.find('.btn-give-admin, .btn-remove-admin');
                var btnText = (newRole === 'admin') ? 'Забрать права' : 'Дать права Администратора';
                var btnClass = (newRole === 'admin') ? 'btn-danger' : 'btn-success';
                $btn.text(btnText).toggleClass('btn-success btn-danger ' + btnClass);
                $btn.data('user-role', newRole);
            }
        });
    });

    // Event delegation for sidebar buttons
    $('body').on('click', '.sidebar-button', function() {
        var panelId = $(this).data('panel-id');
        $panels.hide();
        $('#' + panelId).show();
        $infoAdmin.empty(); // Remove the content of the info-admin div
    });
});
$(document).ready(function () {
    $('.info-panel-user').on('click', '#logout', function(event){
        event.preventDefault();

        $.ajax({
            url: '/admin/ajax/logout.php',
            method: 'POST',
            success: function(response){
                window.location.href = "/afisha";
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});
$(document).ready(function() {
    $('#addMovieForm').submit(function(event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию
        var container = $('#container-admin-films');
        var idKp = $('input[name="id_kp"]').val(); // Получаем значение ID Кинопоиска из поля ввода

        // Отправка AJAX-запроса на сервер
        $.ajax({
            url: '/admin/ajax/add-film.php',
            method: 'POST',
            data: {
                id_kp: idKp
            },
            success: function(response) {
                var content = $(response).find('#content').html(); // Получаем содержимое нужных элементов
                container.html(content); // Обновляем содержимое контейнера
                console.log(response); // Ответ от сервера
                $('#exampleModal').modal('hide'); // Закрытие модального окна после успешного добавления фильма

                var successMessage = 'Фильм добавлен';

                // Отображение сообщения об успешном добавлении фильма
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(successMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function() {
                    $('#error-message').hide();
                }, 5000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#exampleModal').modal('hide');
                // Обработка ошибки
                var errorMessage = 'Ошибка с добавлением, проверьте ID';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-danger')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function() {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });

    $('#addMovieButton').click(function() {
        $('#addMovieForm').submit(); // Вызов события submit формы
    });
});
$(document).ready(function() {
    $('.delete-btn').click(function() {
        var filmId = $(this).data('id');

        $.ajax({
            url: '/admin/ajax/delete-film.php', // Замените на путь к вашему скрипту для удаления фильма
            type: 'POST',
            data: { filmId: filmId },
            success: function(response) {
                var errorMessage = 'Удалено';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function() {
                    $('#error-message').hide();
                }, 5000);
                $('.card-movie-admin[data-id="' + filmId + '"]').remove();
            },
            error: function(xhr, status, error) {
                // Обработка ошибки удаления фильма
                var errorMessage = 'Ошибка с удалением';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-danger')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function() {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });
});
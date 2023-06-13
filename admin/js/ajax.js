$(document).ready(function() {
    var $userRows = $('.user-row');
    var $panels = $('.panel');
    var $updateRoleForms = $('.update-role-form');
    var $infoAdmin = $('.info-admin');

    // Event delegation for admin/user buttons
    $userRows.on('click', '.btn-give-admin, .btn-remove-admin', function (evt) {
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
            success: function (response) {
                $userRow.find('.user-role').html(newRoleText);
                var $btn = $userRow.find('.btn-give-admin, .btn-remove-admin');
                var btnText = (newRole === 'admin') ? 'Забрать права' : 'Дать права Администратора';
                var btnClass = (newRole === 'admin') ? 'btn-danger' : 'btn-success';
                $btn.text(btnText).toggleClass('btn-success btn-danger ' + btnClass);
                $btn.data('user-role', newRole);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Event delegation for sidebar buttons
    $('body').on('click', '.sidebar-button', function () {
        var panelId = $(this).data('panel-id');
        $panels.hide();
        $('#' + panelId).show();
        $infoAdmin.empty(); // Remove the content of the info-admin div
    });

    $('.info-panel-user').on('click', '#logout', function (event) {
        event.preventDefault();

        $.ajax({
            url: '/admin/ajax/logout.php',
            method: 'POST',
            success: function (response) {
                window.location.href = "/afisha";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('#addMovieForm').submit(function (event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию
        var container2 = $('.content'); // Ищем элемент с классом container-seans
        var idKp = $('input[name="id_kp"]').val(); // Получаем значение ID Кинопоиска из поля ввода

        // Отправка AJAX-запроса на сервер
        $.ajax({
            url: '/admin/ajax/add-film.php',
            method: 'POST',
            data: {
                id_kp: idKp
            },
            success: function (response) {
                var content = $(response).find('#container-admin-films').html(); // Получаем содержимое элемента с классом .container-film из ответа сервера
                container2.html(content); // Заменяем содержимое контейнера .content на полученное содержимое .container-film
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
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
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
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });

    $('#addMovieButton').click(function () {
        $('#addMovieForm').submit(); // Вызов события submit формы
    });

    $('.delete-btn').click(function () {
        var filmId = $(this).data('id');

        $.ajax({
            url: '/admin/ajax/delete-film.php', // Замените на путь к вашему скрипту для удаления фильма
            type: 'POST',
            data: {filmId: filmId},
            success: function (response) {
                var errorMessage = 'Удалено';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
                $('.card-movie-admin[data-id="' + filmId + '"]').remove();
            },
            error: function (xhr, status, error) {
                // Обработка ошибки удаления фильма
                var errorMessage = 'Ошибка с удалением';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-danger')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });

    $(document).on('click', '.edit-movie-btn', function () {
        var movieId = $(this).data('movie-id');
        $.ajax({
            url: '/admin/ajax/edit_movie.php',
            method: 'POST',
            data: {movieId: movieId},
            success: function (response) {
                var movie = JSON.parse(response);
                $('#movie_title').val(movie.movie_title);
                $('#movie_restriction').val(movie.movie_restriction);
                $('#movie_image').val(movie.movie_image);
                $('#movie_genre').val(movie.movie_genre);
                $('#movie_description').val(movie.movie_description);
                $('#movie_duration').val(movie.movie_duration);
                $('#movie_country').val(movie.movie_country);
                $('#movie_trailer').val(movie.movie_trailer);

                // Сохраняем movieId в data атрибуте кнопки сохранения изменений
                $('#save_changes').data('movie-id', movieId);
            },
            error: function (xhr, status, error) {
                // Обработка ошибки удаления фильма
                var errorMessage = 'Ошибка при редактировании';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-danger')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });

    $('#save_changes').click(function () {
        var movieId = $(this).data('movie-id');
        console.log('movieId:', movieId);// Получаем movieId из data атрибута кнопки
        var movieData = {
            movieId: movieId,
            movieTitle: $('#movie_title').val(),
            movieRestriction: $('#movie_restriction').val(),
            movieImage: $('#movie_image').val(),
            movieGenre: $('#movie_genre').val(),
            movieDescription: $('#movie_description').val(),
            movieDuration: $('#movie_duration').val(),
            movieCountry: $('#movie_country').val(),
            movieTrailer: $('#movie_trailer').val()
        };

        $.ajax({
            url: '/admin/ajax/update_movie.php',
            method: 'POST',
            data: movieData,
            success: function (response) {
                $('#editMovieModal').modal('hide');
                var errorMessage = 'Фильм успешно обновлен';

                // Отображение сообщения об успехе
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об успехе на некоторое время
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            },
            error: function (xhr, status, error) {
                var errorMessage = 'Ошибка при обновлении фильма';

                // Отображение сообщения об ошибке
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-danger')
                    .text(errorMessage)
                    .show();

                // Затемнение сообщения об ошибке на некоторое время
                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });
});
$(document).on('click', '.delete-order', function () {
    var orderId = $(this).data('order');

    $.ajax({
        url: '/admin/ajax/delete-order.php',
        type: 'POST',
        data: {orderId: orderId},
        success: function (response) {
            var errorMessage = 'Заказ удален';
            $('#exampleModal').modal('hide');
            $('#error-message')
                .removeClass()
                .addClass('alert alert-success')
                .text(errorMessage)
                .show();

            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);

            $('.card-order-admin[data-order-id="' + orderId + '"]').remove();

            // Закрытие модального окна

        },
        error: function (xhr, status, error) {
            var errorMessage = 'Ошибка с удалением';

            $('#error-message')
                .removeClass()
                .addClass('alert alert-danger')
                .text(errorMessage)
                .show();

            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        }
    });
});
$(document).ready(function() {
    $('#addSeansButton').click(function() {
        // Получаем значения полей формы
        var movieId = $('#movieSelect').val();
        var time = $('#timeInput').val();
        var date = $('#dateInput').val();
        var price = $('#priceInput').val();

        // Отправляем AJAX-запрос на сервер
        $.ajax({
            url: '/admin/ajax/add-seans.php',
            type: 'POST',
            data: {
                movie: movieId,
                time: time,
                date: date,
                price: price
            },
            success: function(response) {
                // Обработка успешного ответа от сервера
                var result = JSON.parse(response);
                if (result.success) {
                    alert(result.message);
                    // Закрываем модальное окно после успешного добавления
                    var errorMessage = 'Сеанс добавлен';
                    $('#seansAdd').modal('hide');
                    $('#error-message')
                        .removeClass()
                        .addClass('alert alert-success')
                        .text(errorMessage)
                        .show();

                    setTimeout(function () {
                        $('#error-message').hide();
                    }, 5000);
                } else {
                    alert('Ошибка: ' + result.message);
                }
            },
            error: function() {
                // Обработка ошибки AJAX-запроса
                var errorMessage = 'Сеанс добавлен';
                $('#seansAdd').modal('hide');
                $('#error-message')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(errorMessage)
                    .show();

                setTimeout(function () {
                    $('#error-message').hide();
                }, 5000);
            }
        });
    });
});
$(document).on('click', '#delete-seans', function () {
    var seansId = $(this).data('seansid');
    $.ajax({
        url: '/admin/ajax/delete_seans.php',
        type: 'POST',
        data: {seansId: seansId},
        success: function (response) {
            var errorMessage = 'Сеанс    удален';
            $('#error-message')
                .removeClass()
                .addClass('alert alert-success')
                .text(errorMessage)
                .show();

            // Загрузка содержимого контейнера #seans после успешного удаления
            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        },
        error: function (xhr, status, error) {
            var errorMessage = 'Ошибка с удалением';
            $('#error-message')
                .removeClass()
                .addClass('alert alert-danger')
                .text(errorMessage)
                .show();

            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        }
    });
});
$(document).on('click', '#edit-seans', function () {
    var seansId = $(this).data('seansid');
    $.ajax({
        url: '/admin/ajax/edit_seans.php',
        method: 'POST',
        data: {seansId: seansId},
        success: function (response) {
            var seans = JSON.parse(response);
            $('#date_movie').val(seans.date_movie);
            $('#time_movie').val(seans.time_movie);
            $('#price').val(seans.price);

            // Сохраняем movieId в data атрибуте кнопки сохранения изменений
            $('#save_changes').data('seansid', seansId);
        },
        error: function (xhr, status, error) {
            // Обработка ошибки удаления фильма
            var errorMessage = 'Ошибка при редактировании';

            // Отображение сообщения об ошибке
            $('#error-message')
                .removeClass()
                .addClass('alert alert-danger')
                .text(errorMessage)
                .show();

            // Затемнение сообщения об ошибке на некоторое время
            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        }
    });
});
$(document).on('click', '#save_changes-seans', function () {
    var seansid = $(this).attr('data-seansid');
    var seans = {
        seansId: seansid,
        dateMovie: $('#date_movie').val(),
        timeMovie: $('#time_movie').val(),
        price: $('#price').val()
    };

    $.ajax({
        url: '/admin/ajax/update_seans.php',
        method: 'POST',
        data: JSON.stringify(seans),
        contentType: 'application/json',
        success: function (response) {
            $('#editSeansModal').modal('hide');
            var errorMessage = 'Сеанс успешно обновлен';

            $('#error-message')
                .removeClass()
                .addClass('alert alert-success')
                .text(errorMessage)
                .show();

            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        },
        error: function (xhr, status, error) {
            var errorMessage = 'Ошибка при обновлении сеанса';

            $('#error-message')
                .removeClass()
                .addClass('alert alert-danger')
                .text(errorMessage)
                .show();

            setTimeout(function () {
                $('#error-message').hide();
            }, 5000);
        }
    });
});

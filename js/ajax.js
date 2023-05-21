$(document).ready(function () {
    $('.container-info-booking-film').on('click', '#pay-btn', function(event){
        event.preventDefault();
        $("#brone").html("<div class='loader'></div>");
        $.ajax({
            url: '../ajax/ajaxPayment.php',

            type: 'POST',
            success: function(response) {
                $("#brone").html(response);
            },
            beforeSend: function() {
                $(".loader").show();
            },
            complete: function() {
                $(".loader").hide();
                $('#final').addClass('dope');
            },
            error: function(xhr, status, error) {
                // обрабатываем ошибку
            }
        });
    });
});

$(document).ready(function () {
    var selectedSeats = [];
    var price = $(".price-count").attr('data-price');
    $(".seat.available, .seat.pick").on("click", function () {
        if ($(this).hasClass("available")) {
            $(this).removeClass("available").addClass("pick");
            selectedSeats.push($(this).attr('data-seat'));
        } else if ($(this).hasClass("pick")) {
            $(this).removeClass("pick").addClass("available");
            var index = selectedSeats.indexOf($(this).attr('data-seat'));
            if (index > -1) {
                selectedSeats.splice(index, 1)
            }
        }
        console.log(selectedSeats.lenght + " Место выбрано: " + selectedSeats.join(", "));
        if (selectedSeats.length > 0) { // Добавляем условие проверки
            $.ajax({
                url: "../ajax/ajaxBooking.php",
                type: "POST",
                dataType: "html", // Изменяем тип данных на "html", т.к. ответ содержит HTML-разметку
                data: {
                    seats: selectedSeats, price: price
                },
                success: function (response) {
                    $('.info-pay').html(response);
                    // Добавляем обработчик клика на кнопку заказа
                    $('#btn-order').click(function(e) {
                        e.preventDefault(); // предотвращаем перезагрузку страницы

                        var bookData = $('#seats-count').data('book');
                        if (selectedSeats.length > 0) { // добавляем проверку наличия выбранных мест
                            $("#brone").html("<div class='loader'></div>");
                            $.ajax({
                                url: '../ajax/ajaxOrder.php',

                                type: 'POST',
                                data: {
                                    book: JSON.stringify(bookData),
                                    selected_seat: selectedSeats
                                },
                                success: function(response) {
                                    $("#brone").html(response);
                                },
                                beforeSend: function() {
                                    $(".loader").show();
                                },
                                complete: function() {
                                    $(".loader").hide();

                                },
                                error: function(xhr, status, error) {
                                    // обрабатываем ошибку
                                }

                            });
                        }
                    });
                }
            });
        }
    });
    // Добавляем обработчик клика на кнопку заказа вне цикла события клика на место
    $('#btn-order').click(function(e) {
        if (selectedSeats.length === 0) { // проверяем, что выбрано хотя бы одно место
            e.preventDefault(); // предотвращаем отправку формы
            console.log("Выберите место для заказа!");
        }
    });
});
$(document).ready(function () {

    $("#registration-form").submit(function (event) {
        event.preventDefault();
        var form = $(this);
        var data = JSON.stringify(form.serialize());
        $.ajax({
            url: "/ajax/ajaxReg.php",
            type: "post",
            data: {data: data},
            success: function (response) {
                if (response == true) {
                    $("#error").removeClass('error');
                } else {
                    window.location.replace("/auth");
                }
            }
        });
    });
});
$(document).ready(function () {

    $("#auth-form").submit(function (event) {
        event.preventDefault();
        var form = $(this);
        var data = JSON.stringify(form.serialize());
        $.ajax({
            url: "/ajax/ajaxAuth.php",
            type: "post",
            data: {data: data},
            success: function (response) {
                console.log(response);
                if (response) {
                    window.location.replace("/profile");
                } else {
                    $("#error").addClass('error');
                }
            }
        });
    });
});
$(document).ready(function() {
    $('.choose-date a').click(function(e) {
        e.preventDefault(); // Отменяем стандартное поведение ссылки
        $('.choose-date a').removeClass('choosed'); // Удаляем класс active у всех ссылок
        $(this).addClass('choosed'); // Добавляем класс active к выбранной ссылке
        var href = $(this).attr('href'); // Получаем ссылку, на которую кликнули
        var container = $('.container-catalog'); // Ищем элемент с классом container-catalog
        var container2 = $('.container-film'); // Ищем элемент с классом container-seans
        if (container.length == 0) {
            container = $('.container-film'); // Если не нашли элемент с классом container-catalog, то ищем элемент с классом container-film
        }
        if (container2.length == 0) {
            container2 = $('.container-times'); // Если не нашли элемент с классом container-seans, то ищем элемент с классом container-times
        }
        $.ajax({
            url: href,
            success: function(data) {
                var content = $(data).find('.container-catalog, .container-film'); // Получаем содержимое нужных элементов
                container.html(content.filter('.container-catalog').html()); // Обновляем содержимое элемента с классом container-catalog на странице
                container2.html(content.filter('.container-film').html()); // Обновляем содержимое элемента с классом container-seans на странице
            }
        });
    });
});
$(document).ready(function () {
    $('.user-info').on('click', '#logout-btn', function(event){
        event.preventDefault();
        $.ajax({
            url: '../ajax/logout.php',
            success: function(response){
                window.location.href = "/afisha";
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});
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
$(document).ready(function () {
    $('#logout-btn').click(function (event) {
        event.preventDefault(); // предотвращаем переход по ссылке
        $.ajax({
            url: '/ajax/logout.php',
            success: function (response) {
                window.location.href = '/auth';
            },
            error: function (xhr, status, error) {
                alert('Произошла ошибка при выходе');
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
        $.ajax({
            url: "../ajax/test.php",
            type: "POST",
            dataType: "json",
            data: {
                seats: selectedSeats
            },
            success: function (response) {
                var content = $(response).find('.info-pay'); // Получаем содержимое нужного элемента
                container.html(content.html());
            }
        })
    })
})
$(document).ready(function() {
    $('.choose-date a').click(function(e) {
        e.preventDefault(); // Отменяем стандартное поведение ссылки
        $('.choose-date a').removeClass('active'); // Удаляем класс active у всех ссылок
        $(this).addClass('active'); // Добавляем класс active к выбранной ссылке
        var href = $(this).attr('href'); // Получаем ссылку, на которую кликнули
        var container = $('.container-catalog'); // Ищем элемент с классом container-catalog
        var container2 = $('.container-seans'); // Ищем элемент с классом container-seans
        if (container.length == 0) {
            container = $('.container-film'); // Если не нашли элемент с классом container-catalog, то ищем элемент с классом container-film
        }
        if (container2.length == 0) {
            container2 = $('.container-times'); // Если не нашли элемент с классом container-seans, то ищем элемент с классом container-times
        }
        $.ajax({
            url: href,
            success: function(data) {
                var content = $(data).find('.container-catalog, .container-seans'); // Получаем содержимое нужных элементов
                container.html(content.filter('.container-catalog').html()); // Обновляем содержимое элемента с классом container-catalog на странице
                container2.html(content.filter('.container-seans').html()); // Обновляем содержимое элемента с классом container-seans на странице
            }
        });
    });
});
$.ajax({
    url: href,
    success: function(data) {
        var content = $(data).find('.container-catalog'); // Получаем содержимое нужного элемента
        container.html(content.html()); // Обновляем содержимое на странице
        // Добавляем movie_id и id к ссылке на бронирование
        $('.block-time a').each(function() {
            var href = $(this).attr('href');
            var movie_id = getParameterByName('id', href);
            var seans_id = getParameterByName('seans', href);
            href = '/booking?id=' + movie_id + '&seans=' + seans_id;
            $(this).attr('href', href);
        });
    }
});

// Функция для получения значения GET-параметра по имени
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
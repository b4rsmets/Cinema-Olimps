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
        var container = $('.container-catalog'); // Ищем элемент с классом container-times
        if (container.length == 0) {
            container = $('.container-film'); // Если не нашли элемент с классом container-times, то ищем элемент с классом container-card
        }
        $.ajax({
            url: href,
            success: function(data) {
                var content = $(data).find('.container-catalog'); // Получаем содержимое нужного элемента
                container.html(content.html()); // Обновляем содержимое на странице
            }
        });
    });
});
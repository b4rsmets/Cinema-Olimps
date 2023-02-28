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
                seats: JSON.stringify(selectedSeats),
                price: price
            },
            success: function (response) {
                response = data;
                $('.selected_seat').html(response);
            }
        })
    })
})
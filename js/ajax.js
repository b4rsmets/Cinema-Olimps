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
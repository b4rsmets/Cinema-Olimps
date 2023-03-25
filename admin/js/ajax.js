$(document).ready(function() {
    $('.btn-give-admin, .btn-remove-admin').click(function(evt) {
        evt.preventDefault();
        var userId = $(this).data('user-id');
        var userRole = $(this).data('user-role');
        var newRole = (userRole === 'user') ? 'admin' : 'user';
        var newRoleText = (newRole === 'admin') ? 'Админ' : 'Пользователь';
        var $userRow = $(this).closest('.user-row');

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
                $btn.text(btnText);
                $btn.removeClass('btn-success btn-danger').addClass(btnClass);
                $btn.data('user-role', newRole);
            }
        });
    });
});

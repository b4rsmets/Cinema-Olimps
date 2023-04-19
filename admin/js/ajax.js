$(document).ready(function() {
    var $userRows = $('.user-row');
    var $panels = $('.panel');
    var $updateRoleForms = $('.update-role-form');

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
    });
});
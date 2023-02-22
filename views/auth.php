<?php
namespace views;
class auth
{

}

    if (!empty($_SESSION['auth'])) {
        header("location: /profile");
    }
    else{
    ?>
<div class="reg-container">
    <form id="auth-form" action="">
        <div class="form-reg-container">
            <h1>Вход</h1>
            <hr>
            <label for="login"><b>Логин</b></label>
            <input type="text" placeholder="Введите логин" name="login" required>
            <label for="password"><b>Пароль</b></label>
            <input type="password" placeholder="Введите пароль" name="password" required>
            <hr class="line-reg">
            <button type="submit" id="auth-btn" class="authbtn">Вход</button>
        </div>
        <div class="container-signin">
            <p>У вас нет аккаунта? <a href="/reg">Зарегистрироваться</a>.</p>
        </div>
    </form>
</div>
<?
}
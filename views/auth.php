<?php
namespace views;
class auth
{

}
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
            <p>У вас уже есть аккаунт? <a href="/auth">Войти</a>.</p>
        </div>
    </form>
</div>
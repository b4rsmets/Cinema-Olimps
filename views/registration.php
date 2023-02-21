<?php
namespace views;
class registration
{

}

?>
<div class="reg-container">
    <form id="registration-form" action="">
        <div class="form-reg-container">
            <h1>Регистрация</h1>
            <hr>

            <label for="login"><b>Логин</b></label>
            <input type="text" placeholder="Введите логин" name="login" required>
            <label for="password"><b>Пароль</b></label>
            <input type="password" placeholder="Введите пароль (минимум 6 символов)" name="password" required>
            <hr class="line-reg">
            <p>Создавая аккаунт Вы соглашаетесь с <a href="#">Terms & Privacy</a>.</p>
            <button type="submit" id="reg-btn" class="registerbtn">Зарегистрироваться</button>
        </div>
        <div class="container-signin">
            <p>У вас уже есть аккаунт? <a href="#">Войти</a>.</p>
        </div>
        <div id="error" class="error">
            <h2>Такой логин уже существует или пароль меньше 6 символов!</h2>
        </div>
    </form>
</div>
<?php
namespace views;
class registration
{

}
if (!empty($_SESSION['auth'])) {
    header("location: /profile");
}
else{
?>

<div class="reg-container">
    <form id="registration-form" action="">
        <div class="form-reg-container">
            <h1>Регистрация</h1>
            <hr>
            <label for="login"><b>Логин</b></label>
            <input type="text" pattern="[a-zA-Z0-9]+" placeholder="Введите логин" name="login" required>
            <label for="full_name"><b>Ваше имя</b></label>
            <input type="text" pattern="[А-Яа-яЁё ]+" placeholder="Как вас зовут" name="full_name" required>
            <label for="email"><b>Email</b></label>
            <input type="email"  placeholder="Email" name="email" required>
            <label for="password"><b>Пароль</b></label>
            <input type="password" pattern=".{6,}"  placeholder="Введите пароль (минимум 6 символов)" name="password" required>
            <hr class="line-reg">
            <p>Создавая аккаунт Вы соглашаетесь с <a href="#">Terms & Privacy</a>.</p>
            <button type="submit" id="reg-btn" class="registerbtn">Зарегистрироваться</button>
        </div>
        <div id="error" class="error">
            <h2>Такой логин уже существует!</h2>
        </div>
    </form>
</div>
<?
}
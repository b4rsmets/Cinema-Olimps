<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Medoo\Medoo;

$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'cinemaolimp',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

// Если информация о пользователе уже была загружена, то используем её
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    // Иначе загружаем информацию о пользователе из базы данных
    $user = $db->get('users', '*', ['id' => $_SESSION['user_id']]);
    $_SESSION['user'] = $user;
}?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin/style/style.css">
    <title>Админ панель</title>
</head>
<body>
<div class="wrapper-admin">
    <header class="header-admin">

        <h2 class="text-in-header-admin">Админ панель кинотеатра Олимп</h2>

        <a class="btn btn-primary" href="/afisha" role="button">Вернуться на сайт</a>
    </header>
</div>

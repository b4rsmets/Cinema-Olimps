<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../template/jsconnect.php';

use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'cinemaolimp',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

// Получение данных фильма из AJAX-запроса
$filmId = $_POST['filmId'];
$filmTitle = $_POST['filmTitle'];

// Обновление данных фильма в базе данных
$database->update('movies', ['movie_title' => $filmTitle], ['id' => $filmId]);

// Возвращаем успешный статус редактирования
?>
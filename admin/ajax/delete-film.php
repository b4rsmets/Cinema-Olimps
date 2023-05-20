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

// Получение идентификатора фильма из AJAX-запроса
$filmId = $_POST['filmId'];

// Удаление фильма из базы данных
$database->delete('movies', ['id' => $filmId]);

// Возвращаем успешный статус удаления
?>

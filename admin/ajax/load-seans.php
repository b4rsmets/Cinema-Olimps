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

$movieId = $_POST['movieId'];

$seansList = $database->select('seans', [
    '[>]movies' => ['movie_id' => 'id']
], [
    'seans.id',
    'seans.date_movie',
    'seans.time_movie',
    'movies.id(movie_id)',
    'movies.movie_title',
], [
    'movies.id' => $movieId
]);

if (empty($seansList)) {
    // Если список сеансов пуст, формируем сообщение об ошибке
    $response = [
        'success' => false,
        'message' => 'Сеансы не найдены для указанного фильма'
    ];
} else {
    // Если список сеансов не пуст, формируем успешный ответ с данными
    $seansItems = [];
    foreach ($seansList as $seans) {
        if ($seans['date_movie'] && $seans['time_movie']) {
            $seansItems[] = [
                'date' => $seans['date_movie'],
                'time' => $seans['time_movie']
            ];
        }
    }
    $response = [
        'success' => true,
        'seansList' => $seansItems
    ];
}

// Устанавливаем заголовок Content-Type для возвращаемых данных
header('Content-Type: application/json');
// Возвращаем результат в формате JSON
echo json_encode($response);

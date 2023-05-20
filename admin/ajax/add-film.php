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

$idKp = $_POST['id_kp'];

// Получаем данные из API Кинопоиска
$url = file_get_contents("https://api.kinopoisk.dev/v1/movie/$idKp?token=0QXFJ1B-0GR4ZVZ-P3A4H88-7RP9J1W");
if ($url === false) {
    http_response_code(500); // Устанавливаем статус ответа 500 (внутренняя ошибка сервера)
    die();
} else {
    $content = json_decode($url, true);

    // Фильтруем полученные данные
    $filteredContent = array(
        'id' => $content['id'],
        'name' => $content['name'],
        'year' => $content['year'],
        'description' => $content['description'],
        'duration' => $content['movieLength'],
        'genres' => $content['genres'][0]['name'],
        'countries' => $content['countries'][0]['name'],
        'poster' => $content['poster']['url'],
        'trailer' => $content['videos']['trailers'][0]['url'],
        'kpRating' => substr($content['rating']['kp'], 0, 3),
        'age' => $content['ageRating']
    );

    // Сохраняем изображение на сервере
    $imagePath = '../../resource/uploads/afisha/' . $filteredContent['id'] . '.jpg';
    if (!file_exists($imagePath)) {
        $imageContent = file_get_contents($filteredContent['poster']);
        file_put_contents($imagePath, $imageContent);
    }

    // Вставляем данные фильма в базу данных
    $database->insert('movies', [
        'movie_title' => $filteredContent['name'],
        'movie_url' => $filteredContent['id'],
        'movie_image' => $filteredContent['id'] . '.jpg',
        'movie_restriction' => $filteredContent['age'],
        'movie_genre' => $filteredContent['genres'],
        'movie_description' => $filteredContent['description'],
        'movie_duration' => $filteredContent['duration'],
        'movie_country' => $filteredContent['countries'],
        'movie_trailer' => $filteredContent['trailer'],
        'movie_premier' => $filteredContent['id']
    ]);
}
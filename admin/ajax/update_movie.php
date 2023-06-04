<?php
session_start();
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


$movieId = $_SESSION['movie_id'];

$movieTitle = $_POST['movieTitle'];
$movieRestriction = $_POST['movieRestriction'];
$movieImage = $_POST['movieImage'];
$movieGenre = $_POST['movieGenre'];
$movieDescription = $_POST['movieDescription'];
$movieDuration = $_POST['movieDuration'];
$movieCountry = $_POST['movieCountry'];
$movieTrailer = $_POST['movieTrailer'];

// Получить текущую запись фильма
$movie = $database->get('movies', '*', ['id' => $movieId]);

// Проверить каждое поле на изменение и исключить непроизведенные изменения
$updateData = [];
if ($movieTitle !== $movie['movie_title'] && !empty($movieTitle)) {
    $updateData['movie_title'] = $movieTitle;
}
if ($movieRestriction !== $movie['movie_restriction'] && !empty($movieRestriction)) {
    $updateData['movie_restriction'] = $movieRestriction;
}
if ($movieGenre !== $movie['movie_genre'] && !empty($movieGenre)) {
    $updateData['movie_genre'] = $movieGenre;
}
if ($movieDescription !== $movie['movie_description'] && !empty($movieDescription)) {
    $updateData['movie_description'] = $movieDescription;
}
if ($movieDuration !== $movie['movie_duration'] && !empty($movieDuration)) {
    $updateData['movie_duration'] = $movieDuration;
}
if ($movieCountry !== $movie['movie_country'] && !empty($movieCountry)) {
    $updateData['movie_country'] = $movieCountry;
}
if ($movieTrailer !== $movie['movie_trailer'] && !empty($movieTrailer)) {
    $updateData['movie_trailer'] = $movieTrailer;
}

// Если поле movieImage не пустое, обработайте его исключительно для получения названия файла и расширения
if (!empty($movieImage)) {
    $filename = basename($movieImage);
    $targetDirectory = realpath('../../resource/uploads/afisha/') . '/';
    $targetPath = $targetDirectory . $filename;
    move_uploaded_file($_FILES['movieImage']['tmp_name'], $targetPath);
    $updateData['movie_image'] = $filename;

}

$database->update('movies', $updateData, ['id' => $movieId]);

$response = [
    'success' => true,
    'message' => 'Данные успешно обновлены.'
];

echo json_encode($response);
unset($_SESSION['movie_id']);

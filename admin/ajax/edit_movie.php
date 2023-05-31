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

$film = $database->get('movies', [
    'id',
    'movie_title',
    'movie_image',
    'movie_restriction',
    'movie_genre',
    'movie_description',
    'movie_duration',
    'movie_country',
    'movie_trailer'
], [
    'id' => $movieId
]);

$response = [
    'id' => $film['id'],
    'movie_title' => $film['movie_title'],
    'movie_restriction' => $film['movie_restriction'],
    'movie_image' => $film['movie_image'],
    'movie_genre' => $film['movie_genre'],
    'movie_description' => $film['movie_description'],
    'movie_duration' => $film['movie_duration'],
    'movie_country' => $film['movie_country'],
    'movie_trailer' => $film['movie_trailer']
];

echo json_encode($response);
?>

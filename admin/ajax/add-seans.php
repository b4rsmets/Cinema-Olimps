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

// Получаем данные из AJAX-запроса
$movieId = $_POST['movie'];
$time = $_POST['time'];
$date = $_POST['date'];
$price = $_POST['price'];

// Добавляем сеанс в базу данных со значением hall_id = 1
$database->insert('seans', [
    'movie_id' => $movieId,
    'time_movie' => $time,
    'date_movie' => $date,
    'price' => $price,
    'hall_id' => 1
]);

// Возвращаем ответ клиенту в формате JSON
$response = ['success' => true, 'message' => 'Сеанс успешно добавлен'];
header('Content-Type: application/json');
echo json_encode($response);
?>

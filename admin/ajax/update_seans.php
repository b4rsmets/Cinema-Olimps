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

// Получаем JSON-строку данных
$jsonData = file_get_contents('php://input');

// Преобразуем JSON в массив
$seans = json_decode($jsonData, true);

$seansId = $_SESSION['seansId'];
$seansData = $database->get('seans', '*', ['id' => $seansId]);

$updateData = [];
if (!empty($seans['dateMovie'])) {
    $updateData['date_movie'] = $seans['dateMovie'];
} else {
    $updateData['date_movie'] = $seansData['date_movie'];
}

if (!empty($seans['timeMovie'])) {
    $updateData['time_movie'] = $seans['timeMovie'];
} else {
    $updateData['time_movie'] = $seansData['time_movie'];
}

if (!empty($seans['price'])) {
    $updateData['price'] = $seans['price'];
} else {
    $updateData['price'] = $seansData['price'];
}

$database->update('seans', $updateData, ['id' => $seansId]);

$response = [
    'success' => true,
    'message' => 'Данные успешно обновлены.'
];

echo json_encode($response);
unset($_SESSION['seansId']);

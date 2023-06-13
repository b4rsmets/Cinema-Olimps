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
$_SESSION['seansId'] = $_POST['seansId'];
$seansId = $_POST['seansId'];

$seans = $database->get('seans', [
    'id',
    'date_movie',
    'time_movie',
    'price',

], [
    'id' => $seansId
]);

$response = [
    'id' => $seans['id'],
    'date_movie' => $seans['date_movie'],
    'time_movie' => $seans['time_movie'],
    'price' => $seans['price'],
];

echo json_encode($response);
$response;
?>

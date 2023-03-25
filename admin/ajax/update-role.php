<?php
session_start();
header('Cache-Control: no-cache, no-store, must-revalidate');
require_once __DIR__ . '/../vendor/autoload.php';

use Medoo\Medoo;

$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'cinemaolimp',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

$user_id = $_POST['user_id'];
$user_role = $_POST['user_role'];

$db->update('users', ['role' => $user_role], ['id' => $user_id]);

// Обновляем информацию о пользователе в сессии
$user = $db->get('users', '*', ['id' => $user_id]);
$_SESSION['user'] = $user;

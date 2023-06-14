<?php
session_start();
date_default_timezone_set('Asia/Barnaul');
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../template/jsconnect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'cinemaolimp',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

$date = date('Y-m-d'); // Текущая дата в формате гггг-мм-дд

$orders = $database->select('orders', [
    '[>]users' => ['id_user' => 'id'],
    '[>]seans' => ['id_seans' => 'id'],
    '[>]seats' => ['id_seat' => 'id'],
    '[>]movies' => ['seans.movie_id' => 'id']
], [
    'orders.id',
    'orders.ticket_number',
    'orders.qr',
    'orders.date_buy',
    'orders.id_seans',
    'seats.row',
    'seats.place',
    'users.full_name(full_name)',
    'users.phone(phone)',
    'users.email(email)',
    'seans.hall_id(hall_id)',
    'seans.price',
    'seans.id',
    'seans.date_movie(date_movie)',
    'seans.time_movie(time_movie)',
    'movies.movie_title(movie_title)',
    'movies.movie_image(movie_image)'
], [
    'orders.date_buy' => $date
]);

// Создание отчета
// Создание отчета
// Создание отчета
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID Сеанса')
    ->setCellValue('B1', 'Номер билета')
    ->setCellValue('C1', 'QR')
    ->setCellValue('D1', 'Ряд')
    ->setCellValue('E1', 'Место')
    ->setCellValue('F1', 'Имя')
    ->setCellValue('G1', 'Номер телефона')
    ->setCellValue('H1', 'Email')
    ->setCellValue('I1', 'Номер зала')
    ->setCellValue('J1', 'Дата сеанса')
    ->setCellValue('K1', 'Время сеанса')
    ->setCellValue('L1', 'Название фильма')
    ->setCellValue('M1', 'Цена билета')
    ->setCellValue('N1', 'Сумма всех билетов')
    ->setCellValue('O1', 'Количество билетов');

$row = 2; // Начальная строка для записи данных
$totalAmount = 0; // Общая сумма проданных билетов
$totalTickets = count($orders); // Общее количество билетов

// Запись данных в отчет
foreach ($orders as $order) {
    $sheet->setCellValue('A' . $row, $order['id'])
        ->setCellValue('B' . $row, $order['ticket_number'])
        ->setCellValue('C' . $row, $order['qr'])
        ->setCellValue('D' . $row, $order['row'])
        ->setCellValue('E' . $row, $order['place'])
        ->setCellValue('F' . $row, $order['full_name'])
        ->setCellValue('G' . $row, $order['phone'])
        ->setCellValue('H' . $row, $order['email'])
        ->setCellValue('I' . $row, $order['hall_id'])
        ->setCellValue('J' . $row, $order['date_movie'])
        ->setCellValue('K' . $row, $order['time_movie'])
        ->setCellValue('L' . $row, $order['movie_title'])
        ->setCellValue('M' . $row, $order['price']);

    $totalAmount += $order['price']; // Добавление цены билета к общей сумме
    $row++;
}

$sheet->setCellValue('N1', 'Сумма всех билетов'); // Установка текста в ячейку N1
$sheet->setCellValue('O1', 'Количество билетов'); // Установка текста в ячейку O1
$sheet->setCellValue('N2', $totalAmount); // Установка общей суммы в ячейку N2
$sheet->setCellValue('O2', $totalTickets); // Установка общего количества билетов в ячейку O2
$sheet->setCellValue('P1', 'Время создания отчета'); // Установка текста в ячейку Q1
$sheet->setCellValue('P2', sprintf('%02d:%02d', date('H'), date('i'))); // Установка текущего времени в формате чч:мм в ячейку Q2

// Генерация отчета в формате XLSX
$writer = new Xlsx($spreadsheet);
$filename = 'report_' . date('Y-m-d_H-i') . '.xlsx'; // Форматирование имени файла

// Сохранение отчета на сервере
$filePath = __DIR__ . '/../../reports/' . $filename;
$writer->save($filePath);

// Возвращение ссылки на скачивание файла
echo json_encode(['filePath' => $filePath]);
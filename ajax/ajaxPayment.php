<?php
session_start();
require_once '../config.php';
require_once '../lib/full/qrlib.php';
$bookmodel = new models\book();
$bookmodel->orderConfirm();
// Путь к папке QR-кодов
$qrFolderPath = "img/qrcodes";

// Создание папки, если она не существует
if (!file_exists($qrFolderPath)) {
    mkdir($qrFolderPath, 0777, true);
}

// Установка прав на запись для папки
chmod($qrFolderPath, 0777);
$timeNow = date("His");
$qrFile = $_SESSION['role']['id'] . $timeNow ;
$data = "Номер билета: " . $_SESSION['pickedSeat']['seats'][0] . "\n" .
    "Фильм: " . $_SESSION['infoSeans']['title'] . "\n" .
    "Время: " . date('H:i', strtotime($_SESSION['infoSeans']['time'])) . "\n" .
    "Дата: " . date('Y.m.d', strtotime($_SESSION['infoSeans']['date'])) . "\n" .
    "Имя: " . $_SESSION['role']['full_name'];

$qrFilePath = "../resource/qrcodes/bilet_" .  $qrFile . ".png";

QRcode::png($data, $qrFilePath, QR_ECLEVEL_L, 3);

?>
<div class="cardWrap">
    <div class="cardticket cardLeft">
        <h1>Билет <span>в кино</span></h1>
        <div class="titleticket">
            <h2><?= $_SESSION['infoSeans']['title'] ?></h2>
            <span>Фильм</span>
        </div>
        <div class="info-ticket-fl">
        <div class="nameticket">
            <h2><?= $_SESSION['role']['full_name']?></h2>
            <span>Имя</span>
        </div>
        <div class="seatticket">
            <h2><?= $_SESSION['pickedSeat']['seats'][0]?></h2>
            <span>Место</span>
        </div>
        <div class="timeticket">
            <h2><?= date('H:i', strtotime($_SESSION['infoSeans']['time'])) ?></h2>
            <span>Время</span>
        </div>
            <div class="dateticket">
                <h2><?= date('Y.m.d', strtotime($_SESSION['infoSeans']['date'])) ?></h2>
                <span>Дата</span>
            </div>
        </div>
    </div>
    <div class="cardticket cardRight">
        <div class="eye"></div>
        <div class="numberticket">
            <h3><?= $timeNow?></h3>
            <span>Номер билета</span>
            <div class="qr-div">
                <img src="<?=$qrFilePath?>" alt="QR-code">
            </div>
        </div>
    </div>

</div>
<div class="pametka">
<span>Для прохода в зал кинотеатра предьявите QR либо назовите ваше Имя и номер билета</span>
</div>
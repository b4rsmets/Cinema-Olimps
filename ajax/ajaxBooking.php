<?php
session_start();
$_SESSION['pickedSeat'] = [
    'seats' => $_POST['seats'],
    'price' => $_POST['price']
];

$count = 0;

if (is_array($_SESSION['pickedSeat']['seats'])) {
    $count = count($_SESSION['pickedSeat']['seats']);
}
$dataBook = '';
if (isset($_SESSION['pickedSeat']['seats']) && is_array($_SESSION['pickedSeat']['seats'])) {
    $dataBook = implode(',', $_SESSION['pickedSeat']['seats']);
}
?>
<div id="seats-count" data-book="<?=$dataBook?>">
    <span>Билетов выбрано: <span class="selected_seat"><?= $count ?></span></span>
</div>
<div class="price-count" data-price="<?= $_SESSION['pickedSeat']['price'] ?>">
    <span>Цена за один билет <?= $_SESSION['pickedSeat']['price'] ?> ₽</span>
</div>
<div class="price-itog">
    <span>Итоговая цена: <span id="total-price"><?= $_SESSION['pickedSeat']['price'] * $count ?> ₽</span></span>
</div>

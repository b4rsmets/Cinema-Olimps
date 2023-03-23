<?php
use controllers\mainController;
require_once 'config.php';
session_start();
unset($_SESSION['infoSeans']);
unset($_SESSION['pickedSeat']);
unset($_SESSION['total_price']);
unset($_SESSION['seans_id']);
date_default_timezone_set('Asia/Barnaul');

new mainController;
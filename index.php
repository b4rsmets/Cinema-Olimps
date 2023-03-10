<?php
use controllers\mainController;
require_once 'config.php';
session_start();
date_default_timezone_set('Asia/Barnaul');

new mainController;
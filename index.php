<?php
use controllers\mainController;
require_once 'config.php';
include(PATH_SITE."/lib/full/qrlib.php");
session_start();

new mainController;
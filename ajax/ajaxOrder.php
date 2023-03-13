<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['selected_seat'] != 0) {
        if (isset($_POST['book'])) {
            $bookData = $_SESSION['pickedSeat']['seats'];
            echo $bookData;
        }
    } else {
        die;
    }
}

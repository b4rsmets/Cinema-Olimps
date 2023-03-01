<?php


namespace controllers;

class bookingController
{
    function __construct()
    {
        $bookingmodel = new \models\book();
        $data = $bookingmodel->getBookSeans($_GET['id'],$_GET['seans']);
        $seats = $bookingmodel->getSeats($data['hall_id'],$data['id']);
        $indexView = new \views\booking();
        $indexView->render($data, $seats);
    }
}
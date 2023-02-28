<?php


namespace controllers;

class bookingController
{
    function __construct()
    {
        $bookingmodel = new \models\book();
        $data = $bookingmodel->getBookSeans($_GET['id'],$_GET['seans']);
        $indexView = new \views\booking();
        $indexView->render($data);
    }
}
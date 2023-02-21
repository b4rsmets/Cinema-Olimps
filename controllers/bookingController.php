<?php


namespace controllers;

class bookingController
{
    function __construct()
    {
        $bookingmodel = new \models\book();
        $indexView = new \views\booking();
        $indexView->render();
    }
}
<?php
namespace admin\controllers;

class panelController
{
    function __construct()
    {
        $indexView = new \admin\views\panel();
        $indexView->render();
    }

}
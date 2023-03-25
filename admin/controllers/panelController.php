<?php
namespace admin\controllers;

class panelController
{
    function __construct()
    {
        $adminmodel = new \admin\models\admin();
        $indexView = new \admin\views\panel();
        $indexView->render();
    }

}
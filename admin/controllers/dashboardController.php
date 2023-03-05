<?php
namespace admin\controllers;

class dashboardController
{
    function __construct()
    {
        $adminmodel = new \admin\models\admin();
        $indexView = new \admin\views\dashboard();
        $indexView->render();
    }

}
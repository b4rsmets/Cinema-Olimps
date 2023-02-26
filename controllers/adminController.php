<?php
namespace controllers;

class adminController
{
    function __construct()
    {
        $adminmodel = new \models\admin();
        $indexView = new \views\admin();
        $indexView->render();
    }

}
<?php
namespace controllers;

class authController
{
    function __construct()
    {
        $indexmodel = new \models\index();
        $indexView = new \views\auth();
    }

}
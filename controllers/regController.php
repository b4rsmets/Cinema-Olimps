<?php

namespace controllers;

class regController
{

    function __construct()
    {
        $usermodel = new \models\user();
        $data = $usermodel->addUser();
        $indexView = new \views\registration();

    }
}
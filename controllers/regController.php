<?php

namespace controllers;

class regController
{

    function __construct()
    {
        $usermodel = new \models\reg();
        $indexView = new \views\registration();

    }
}
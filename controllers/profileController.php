<?php

namespace controllers;

class profileController
{
    function __construct()
    {
        $usermodel = new \models\user();
        $profileView = new \views\profile();
        $profileView->render();
    }
}

<?php

namespace controllers;

class profileController
{
    function __construct()
    {
            $profilemodel = new \models\profile();
            $profileView = new \views\profile();
            $profileView->render($user);
        }
}


<?php

namespace controllers;

class profileController
{
    function __construct()
    {
            $profilemodel = new \models\profile();
            $user['user'] = $profilemodel ->getInfoUser($_GET['id']);
            $profileView = new \views\profile();
            $profileView->render($user);
        }
}


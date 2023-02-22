<?php

namespace controllers;

class profileController
{
    function __construct()
    {
        if ($_SESSION['auth']){
            $usermodel = new \models\auth();
            $profileView = new \views\profile();
            $profileView->render();
        }
else{

}
    }
}

<?php

namespace controllers;

class profileController
{
    function __construct()
    {
            $profilemodel = new \models\profile();
            $orders = $profilemodel->getOrderSeans($orders);
            $profileView = new \views\profile();
            $profileView->render($orders);
        }
}


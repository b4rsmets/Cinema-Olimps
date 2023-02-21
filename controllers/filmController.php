<?php
namespace controllers;

class filmController
{
    function __construct()
    {
        $indexmodel = new \models\index();
        $films['films'] = $indexmodel->getFilm($_GET['id']);
        $films['seans'] = $indexmodel->getSeans();
        $indexView = new \views\film();
        $indexView->render($films);
    }
}
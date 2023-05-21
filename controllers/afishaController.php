<?php
namespace controllers;

class afishaController
{
    function __construct()
    {
        $indexmodel = new \models\index();
        $data['slider'] = $indexmodel->getSliders();
        $data['films']['seans'] = $indexmodel->getSeans();
        $data['films']['films'] = $indexmodel->getFilms();
        $data['news'] = $indexmodel->getNews();
        $indexView = new \views\index();
        $indexView->render($data);

    }

}
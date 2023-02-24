<?php
namespace controllers;

class apiController
{
    function __construct()
    {
        $apimodel = new \models\api();
        $test = $apimodel->apiMovie($filteredContent);
        $indexView = new \views\api();
        $indexView->render($test);
    }

}
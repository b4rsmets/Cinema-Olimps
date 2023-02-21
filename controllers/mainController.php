<?php

namespace controllers;

class mainController
{

    function __construct()
    {
        if(explode("/",$_GET['route'])[0]!="ajax"){//если это не ajax запрос, ajax запросы обрабатываются по умолчанию с переходом по адресу файла
            require_once "./views/header.php";

            if ($_GET['route'] == "") {
                new indexController;
            } else {
                $controllerName = "\controllers\\" . $_GET['route'] . "Controller";
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                } else {
                    throw new Exception("Controller not found");
                }

            }
            require_once "./views/footer.php";
        }


    }


}
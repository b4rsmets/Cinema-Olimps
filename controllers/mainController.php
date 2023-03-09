<?php

namespace controllers;

class mainController
{

    function __construct()
    {
        $url = explode("/", $_GET['route']);
        if (explode("/", $_GET['route'])[0] != "ajax" && explode("/", $_GET['route'])[0] != "panel") {
            // load header
            require_once "./views/header.php";

            // route requests to non-admin controllers
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

            // load footer
            require_once "./views/footer.php";
        } elseif (explode("/", $_GET['route'])[0] == "panel") {
            // load admin controllers and views
            $adminRoute = str_replace("admin/", "", "dashboard");
            $adminControllerName = "admin\controllers\\" . $adminRoute . "Controller";
            $adminViewPath = str_replace("admin/", "", "dashboard");
            if ($url[0]) {


                if (class_exists($adminControllerName)) {
                    $adminController = new $adminControllerName();
                } else {
                    throw new Exception("Admin controller not found");
                }

                require_once "admin/views/" . $adminViewPath . ".php";
            }
            else {
                require_once "views/404.php";
            }
        }
    }
}

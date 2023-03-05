<?php

namespace controllers;

class mainController
{

    function __construct()
    {
        $url = explode("/", $_GET['route']);

        if ($url[0] == "admin" && empty($url[1])) {
            // load adminController when accessing /admin
            require_once "./controllers/admin/dashboardController.php";
            return;
        }

        if (explode("/", $_GET['route'])[0] != "ajax" && explode("/", $_GET['route'])[0] != "admin") {
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
        } elseif (explode("/", $_GET['route'])[0] == "admin") {
            // load admin controllers and views
            $adminRoute = str_replace("admin/", "", $_GET['route']);
            $adminControllerName = "admin\controllers\\" . $adminRoute . "Controller";
            $adminViewPath = str_replace("admin/", "", $_GET['route']);
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

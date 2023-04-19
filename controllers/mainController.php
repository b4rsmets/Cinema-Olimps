<?php

namespace controllers;

use Exception;

class mainController
{

    function __construct()
    {
        $url = explode("/", $_GET['route']);

        // Load header for non-admin pages
        if (explode("/", $_GET['route'])[0] != "ajax" && explode("/", $_GET['route'])[0] != "panel") {
            require_once "./views/header.php";

            // Route requests to non-admin controllers
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

            // Load footer for non-admin pages
            require_once "./views/footer.php";
        }

        // Load admin pages
        elseif (explode("/", $_GET['route'])[0] == "panel") {
            // Check if user has admin access
            if (empty($_SESSION['role']['role'] == 'admin')) {
                header("location: /afisha");
                exit;
            }
            // Load admin controllers and views
            $adminRoute = str_replace("admin/", "", $url[0]);
            $adminControllerName = "admin\\controllers\\" . $adminRoute . "Controller";
            $adminViewPath = str_replace("admin/", "", $url[0]);

            if ($adminRoute) {
                if (class_exists($adminControllerName)) {
                    $adminController = new $adminControllerName();
                } else {
                    throw new Exception("Admin controller not found");
                }

                require_once "admin/views/" . $adminViewPath . ".php";
            } else {
                require_once "views/404.php";
            }
        }

        // Load AJAX requests
        elseif (explode("/", $_GET['route'])[0] == "ajax") {
            header("Content-Type: application/json");

            if (isset($url[1])) {
                $ajaxControllerName = "\controllers\ajax\\" . $url[1] . "AjaxController";
                if (class_exists($ajaxControllerName)) {
                    $ajaxController = new $ajaxControllerName();
                    $method = $url[2] ?? "index";
                    if (method_exists($ajaxController, $method)) {
                        $ajaxController->$method();
                    } else {
                        echo json_encode(["success" => false, "error" => "Method not found"]);
                    }
                } else {
                    echo json_encode(["success" => false, "error" => "Controller not found"]);
                }
            } else {
                echo json_encode(["success" => false, "error" => "No controller specified"]);
            }
            exit;
        }
    }
}
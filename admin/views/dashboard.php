<?php

namespace admin\views;
class dashboard
{
    function render()
    {
        if (!empty($_SESSION['role']['role'] == 'admin')) {
            $this->viewAdm();

        } else {
            header("location: /afisha");
        }
    }

    function viewAdm()
    {
    require_once 'admin/template/header.php';
    }
}
<?php

namespace views;
class admin
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
        echo 'u Admin';
    }
}
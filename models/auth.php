<?php

namespace models;

class auth
{
    protected $connect;

    function __construct()
    {
        $this->connect = \DBConnect::getInstance()->getConnect();
    }

    function authUser($login, $password)
    {
        $query = $this->connect->query("SELECT * FROM users WHERE login = '$login' AND password = '$password'");
        if ($query->num_rows) {
            $result = $query->fetch_assoc();
            return $result;
        } else {
            return false;
        }
    }

    function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }
}
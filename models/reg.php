<?php

namespace models;

class reg
{
    protected $connect;

    function __construct()
    {
        $this->connect = \DBConnect::getInstance()->getConnect();
    }

    function checkUser($login)
    {
        $query = $this->connect->query("SELECT * FROM users WHERE login = '$login'");
        if ($query->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    function addUser($login, $password, $email, $full_name)
    {
        $query = $this->connect->query("INSERT INTO users (login, email, full_name, password, role) VALUES ('$login', '$email', '$full_name', '$password', 'user')");
        if ($this->connect->error) {
            echo 'Ошибка';
        } else {

        }
    }
}
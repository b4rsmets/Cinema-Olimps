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
    function addUser($login, $password){
        $query = $this->connect->query("INSERT INTO users (login, password, role) VALUES ('$login', '$password', 'user')");
        if($this->connect->error){
            echo 'Ошибка';
        }
        else{

        }
    }
}
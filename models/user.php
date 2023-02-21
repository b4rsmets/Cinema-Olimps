<?php

namespace models;

class user
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
    function addUser(){

    }

}
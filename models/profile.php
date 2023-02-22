<?php

namespace models;

class profile
{
    protected $connect;

    function __construct()
    {
        $this->connect = \DBConnect::getInstance()->getConnect();
    }
    function getInfoUser($id){
        $query = $this->connect->query("SELECT * FROM users WHERE id = $ID");
        if ($query->num_rows) {
            $user = $query->fetch_assoc();
        }
        return $user;
    }
}
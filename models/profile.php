<?php

namespace models;

class profile
{
    protected $connect;

    function __construct()
    {
        $this->connect = \DBConnect::getInstance()->getConnect();
    }
}
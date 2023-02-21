<?php

class DBConnect
{
    private static $instance;
    private static $connect;

    private function __construct()
    {
        self::$connect = mysqli_connect('localhost', 'root', '') or die("Невозможно установить соединение c базой данных" . mysqli_connect_error());
        mysqli_query(self::$connect, 'SET names "utf8"');
        mysqli_select_db(self::$connect, 'cinemaolimp') or die("Ошибка обращения к базе " . mysqli_connect_error());
    }

    public static function getInstance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self;
    }

    function getConnect()
    {
        return self::$connect;
    }

    private function __clone()
    {

    }
}
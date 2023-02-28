<?php
namespace models;

class book
{
    protected $connect;
    function __construct()
    {

        $this->connect = \DBConnect::getInstance()->getConnect();
    }
    function getBookSeans($ID, $seans)
    {
        $query = $this->connect->query("SELECT * FROM movies,seans WHERE movies.id = $ID AND movies.id = seans.movie_id AND seans.id = $seans");
        if ($query->num_rows) {
        $book = $query->fetch_assoc();
        }
        return $book;
    }
}
<?php
namespace models;

class index
{
    protected $connect;

    function __construct()
    {

        $this->connect = \DBConnect::getInstance()->getConnect();
    }

    function getSliders()
    {

        $sql = "SELECT * FROM settings";
        $query = $this->connect->query($sql);
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $sliders[] = $row;
            }
        }
        return $sliders;
    }
    function getFilms()
    {
        $query = $this->connect->query('SELECT * FROM movies');
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $films[] = $row;
            }
        }
        return $films;
    }
    function getSeans()
    {
        $sql = "SELECT * FROM seans ORDER BY time_movie";
        $query = $this->connect->query($sql);
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $seans[] = $row;
            }
        }
        return $seans;
    }
    function getFilm($ID)
    {
        $query = $this->connect->query("SELECT * FROM movies WHERE id = $ID");
        if ($query->num_rows) {
        $film = $query->fetch_assoc();
        }
        return $film;
    }
}
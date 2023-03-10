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
    function getSeats($hall_id){
        $query = $this->connect->query("SELECT * FROM seats,halls WHERE hall_id = $hall_id");
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $seats[] = $row;
            }
        }
        return $seats;
    }
    
    function getInfoSeat($booking){
        $query = $this->connect->query("SELECT * FROM orders,seats,seans WHERE orders.id_seat = seats.id AND orders.id_seans = seans.id");
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $booking[] = $row;
            }
        }
        return $booking;
    }
}
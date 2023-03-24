<?php

namespace models;

class profile
{
    protected $connect;

    function __construct()
    {
        $this->connect = \DBConnect::getInstance()->getConnect();
    }
    function getOrderSeans($orders){
        $userId = $_SESSION['role']['id'];
        $query = $this->connect->query("SELECT * FROM orders
                                    JOIN seans ON seans.id = orders.id_seans
                                    JOIN movies ON seans.movie_id = movies.id JOIN seats ON orders.id_seat = seats.id
                                    WHERE orders.id_user = $userId");
        $orders = array();
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders ;
    }

}
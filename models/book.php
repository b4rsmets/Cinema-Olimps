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

    function getSeats($hall_id)
    {
        $query = $this->connect->query("SELECT seats.id, seats.hall_id, seats.row, seats.place, seats.seans_id, halls.hall_name, halls.hall_close FROM seats,halls WHERE hall_id = $hall_id");
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $seats[] = $row;
            }
        }
        return $seats;
    }

    function getInfoSeat($booking)
    {
        $query = $this->connect->query("SELECT * FROM orders,seats,seans WHERE orders.id_seat = seats.id AND orders.id_seans = seans.id");
        if ($query->num_rows) {
            while ($row = $query->fetch_assoc()) {
                $booking[] = $row;
            }
        }
        return $booking;
    }

    function orderConfirm()
    {
        $now = date('Y.m.d');
        $ticket_number = date("His");;
        $qrPath = $_SESSION['role']['id'] . $ticket_number;
        $query = $this->connect->query("INSERT INTO orders (date_buy, id_seans, id_seat, id_user, ticket_number, qr) VALUES ('{$now}', {$_SESSION['seans_id']}, {$_SESSION['pickedSeat']['seats'][0]}, {$_SESSION['role']['id']}, '{$ticket_number}', '{$qrPath}')");
        if ($this->connect->error) {
            echo 'Ошибка: ' . mysqli_error($this->connect);
        }
    }

    function checkSeat($selectedSeat, $selectedSeans) {
        $stmt = $this->connect->prepare("SELECT * FROM orders WHERE id_seat = ? AND id_seans = ?");
        $stmt->bind_param("ss", $selectedSeat, $selectedSeans);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }
    function checkSeatPayment($selectedSeat, $selectedSeans) {
        $stmt = $this->connect->prepare("SELECT * FROM orders WHERE id_seat = ? AND id_seans = ?");
        $stmt->bind_param("ss", $selectedSeat, $selectedSeans);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }

}
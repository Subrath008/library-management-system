<?php

class Reservation {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getReservations(){

        $stmt = $this->conn->prepare(
            "SELECT reservations.*, books.title
             FROM reservations
             JOIN books ON reservations.book_id = books.id
             ORDER BY reservations.id DESC"
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    public function fulfillReservation($id){

        $stmt = $this->conn->prepare(
            "UPDATE reservations
             SET status='fulfilled'
             WHERE id=?"
        );

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>
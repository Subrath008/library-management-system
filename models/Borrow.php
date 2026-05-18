<?php

class Borrow {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getPendingRequests(){

        $stmt = $this->conn->prepare(
            "SELECT borrow_records.*, books.title
             FROM borrow_records
             LEFT JOIN books
             ON borrow_records.book_id = books.id
             WHERE borrow_records.status='pending'
             ORDER BY borrow_records.id DESC"
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    public function approveRequest($id){

        $borrow_date = date("Y-m-d");

        $due_date = date(
            "Y-m-d",
            strtotime("+14 days")
        );

        $stmt = $this->conn->prepare(
            "UPDATE borrow_records
             SET status='active',
             borrow_date=?,
             due_date=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "ssi",
            $borrow_date,
            $due_date,
            $id
        );

        return $stmt->execute();
    }

    public function rejectRequest($id){

        $stmt = $this->conn->prepare(
            "UPDATE borrow_records
             SET status='rejected'
             WHERE id=?"
        );

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>
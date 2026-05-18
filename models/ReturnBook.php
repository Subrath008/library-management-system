<?php

class ReturnBook {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getBorrowRecord($id){

        $stmt = $this->conn->prepare(
            "SELECT * FROM borrow_records
             WHERE id=?"
        );

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function markReturned($id, $today){

        $stmt = $this->conn->prepare(
            "UPDATE borrow_records
             SET status='returned',
             return_date=?
             WHERE id=?"
        );

        $stmt->bind_param("si", $today, $id);

        return $stmt->execute();
    }

    public function addFine(
        $borrow_record_id,
        $member_id,
        $branch_id,
        $amount,
        $reason
    ){

        $stmt = $this->conn->prepare(
            "INSERT INTO fines
            (borrow_record_id, member_id, branch_id, amount, reason, is_paid)
            VALUES (?, ?, ?, ?, ?, 0)"
        );

        $stmt->bind_param(
            "iiids",
            $borrow_record_id,
            $member_id,
            $branch_id,
            $amount,
            $reason
        );

        return $stmt->execute();
    }
}

?>
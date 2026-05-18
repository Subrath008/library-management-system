<?php

class ManualFine {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
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
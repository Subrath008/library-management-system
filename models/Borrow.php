<?php

class Borrow {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function approveBorrow($id, $borrow_date, $due_date){

        $stmt = $this->conn->prepare(
            "UPDATE borrow_records
             SET status='active',
                 borrow_date=?,
                 due_date=?
             WHERE id=?"
        );

        $stmt->bind_param("ssi", $borrow_date, $due_date, $id);

        return $stmt->execute();
    }

    public function rejectBorrow($id, $reason){

        $stmt = $this->conn->prepare(
            "UPDATE borrow_records
             SET status='rejected',
                 rejection_reason=?
             WHERE id=?"
        );

        $stmt->bind_param("si", $reason, $id);

        return $stmt->execute();
    }
}

?>
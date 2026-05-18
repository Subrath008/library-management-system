<?php

class MemberHistory {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getMember($id){
        $stmt = $this->conn->prepare(
            "SELECT id, name, email, phone, branch_id
             FROM users
             WHERE id=? AND role='member'"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getLoans($id){
        $stmt = $this->conn->prepare(
            "SELECT borrow_records.*, books.title
             FROM borrow_records
             LEFT JOIN books ON borrow_records.book_id = books.id
             WHERE borrow_records.member_id=?
             ORDER BY borrow_records.id DESC"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getFines($id){
        $stmt = $this->conn->prepare(
            "SELECT *
             FROM fines
             WHERE member_id=?
             ORDER BY id DESC"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
<?php

class Member {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function searchMembers($keyword){

        $search = "%" . $keyword . "%";

        $stmt = $this->conn->prepare(
            "SELECT *
             FROM users
             WHERE role='member'
             AND (
                 name LIKE ?
                 OR email LIKE ?
                 OR phone LIKE ?
             )"
        );

        $stmt->bind_param(
            "sss",
            $search,
            $search,
            $search
        );

        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
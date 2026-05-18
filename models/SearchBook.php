<?php

class SearchBook {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function search($keyword){

        $search = "%" . $keyword . "%";

        $stmt = $this->conn->prepare(
            "SELECT *
             FROM books
             WHERE title LIKE ?
             OR author LIKE ?
             OR isbn LIKE ?
             ORDER BY id DESC"
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
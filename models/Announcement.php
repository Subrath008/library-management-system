<?php

class Announcement {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function addAnnouncement($branch_id, $author_id, $title, $body){

        $stmt = $this->conn->prepare(
            "INSERT INTO announcements
            (branch_id, author_id, title, body)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiss",
            $branch_id,
            $author_id,
            $title,
            $body
        );

        return $stmt->execute();
    }

    public function getAllAnnouncements(){

        $stmt = $this->conn->prepare(
            "SELECT * FROM announcements ORDER BY id DESC"
        );

        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
<?php

class Report {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function mostBorrowedBooks(){
        $stmt = $this->conn->prepare(
            "SELECT books.title, COUNT(borrow_records.id) AS total_borrows
             FROM borrow_records
             JOIN books ON borrow_records.book_id = books.id
             GROUP BY books.id, books.title
             ORDER BY total_borrows DESC"
        );

        $stmt->execute();
        return $stmt->get_result();
    }

    public function neverBorrowedBooks(){
        $stmt = $this->conn->prepare(
            "SELECT books.id, books.title, books.author
             FROM books
             LEFT JOIN borrow_records ON books.id = borrow_records.book_id
             WHERE borrow_records.id IS NULL"
        );

        $stmt->execute();
        return $stmt->get_result();
    }

    public function borrowsPerGenre(){
        $stmt = $this->conn->prepare(
            "SELECT genres.name AS genre_name, COUNT(borrow_records.id) AS total_borrows
             FROM genres
             LEFT JOIN books ON genres.id = books.genre_id
             LEFT JOIN borrow_records ON books.id = borrow_records.book_id
             GROUP BY genres.id, genres.name
             ORDER BY total_borrows DESC"
        );

        $stmt->execute();
        return $stmt->get_result();
    }
}

?>
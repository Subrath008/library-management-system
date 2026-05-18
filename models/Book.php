<?php

class Book {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function addBook($title, $author, $isbn, $genre_id, $publisher, $published_year, $description, $cover_image_path){
        $stmt = $this->conn->prepare(
            "INSERT INTO books 
            (title, author, isbn, genre_id, publisher, published_year, description, cover_image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssissss",
            $title,
            $author,
            $isbn,
            $genre_id,
            $publisher,
            $published_year,
            $description,
            $cover_image_path
        );

        return $stmt->execute();
    }

    public function getAllBooks(){
         $stmt = $this->conn->prepare("SELECT * FROM books ORDER BY id DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getBookById($id){
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateBook($id, $title, $author, $isbn, $genre_id, $publisher, $published_year, $description, $cover_image_path){
        $stmt = $this->conn->prepare(
            "UPDATE books 
             SET title=?, author=?, isbn=?, genre_id=?, publisher=?, published_year=?, description=?, cover_image_path=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "sssissssi",
            $title,
            $author,
            $isbn,
            $genre_id,
            $publisher,
            $published_year,
            $description,
            $cover_image_path,
            $id
        );

        return $stmt->execute();
    }

    public function markUnavailable($id){
    $stmt = $this->conn->prepare("UPDATE books SET is_available=0 WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
}

?>
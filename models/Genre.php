<?php

class Genre {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function addGenre($name){
        $stmt = $this->conn->prepare("INSERT INTO genres (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function getAllGenres(){
        $stmt = $this->conn->prepare("SELECT * FROM genres ORDER BY id DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getGenreById($id){
        $stmt = $this->conn->prepare("SELECT * FROM genres WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateGenre($id, $name){
        $stmt = $this->conn->prepare("UPDATE genres SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function isGenreUsed($id){
        $stmt = $this->conn->prepare("SELECT id FROM books WHERE genre_id=? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function deleteGenre($id){
        $stmt = $this->conn->prepare("DELETE FROM genres WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function genreExists($name){

    $name = trim($name);

    $stmt = $this->conn->prepare(
        "SELECT id FROM genres WHERE LOWER(name)=LOWER(?)"
    );

    $stmt->bind_param("s", $name);
    $stmt->execute();

    return $stmt->get_result()->num_rows > 0;
}
}

?>
<?php

class Inventory {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function addInventory(
        $book_id,
        $branch_id,
        $total_copies,
        $available_copies
    ){

        $stmt = $this->conn->prepare(
            "INSERT INTO branch_inventory
            (book_id, branch_id, total_copies, available_copies)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiii",
            $book_id,
            $branch_id,
            $total_copies,
            $available_copies
        );

        return $stmt->execute();
    }

   public function getInventory(){

    $stmt = $this->conn->prepare(
        "SELECT branch_inventory.*, books.title
         FROM branch_inventory
         LEFT JOIN books ON branch_inventory.book_id = books.id
         ORDER BY branch_inventory.id DESC"
    );

    $stmt->execute();

    return $stmt->get_result();
}
}

?>
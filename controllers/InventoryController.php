<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Inventory.php";

$inventoryModel = new Inventory($conn);

$message = "";

if(isset($_POST['save_inventory'])){

    $book_id = $_POST['book_id'];
    $branch_id = $_POST['branch_id'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    if($total_copies < 0 || $available_copies < 0){

        $message = "Copies cannot be negative";

    } elseif($available_copies > $total_copies){

        $message =
            "Available copies cannot exceed total copies";

    } else {

        if($inventoryModel->addInventory(
            $book_id,
            $branch_id,
            $total_copies,
            $available_copies
        )){
            $message =
                "Inventory added successfully";
        }
        else{
            $message =
                "Failed to add inventory";
        }
    }
}

$result = $inventoryModel->getInventory();


$books = $conn->prepare("SELECT id, title FROM books ORDER BY title ASC");
$books->execute();
$booksResult = $books->get_result();

?>
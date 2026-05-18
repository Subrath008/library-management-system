<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/ReturnBook.php";

$returnModel = new ReturnBook($conn);

$message = "";

if(isset($_POST['return_book'])){

    $borrow_record_id = $_POST['borrow_record_id'];

    $record = $returnModel->getBorrowRecord($borrow_record_id);

    if($record){

        $today = date("Y-m-d");

        $returnModel->markReturned(
            $borrow_record_id,
            $today
        );

        if($today > $record['due_date']){

            $days_overdue = floor(
                (strtotime($today) - strtotime($record['due_date']))
                / (60 * 60 * 24)
            );

            $fine_amount = $days_overdue * 5;

            $returnModel->addFine(
                $borrow_record_id,
                $record['member_id'],
                $record['branch_id'],
                $fine_amount,
                "Overdue Book Return"
            );

            $message =
                "Book returned successfully. Fine generated: $" .
                $fine_amount;
        }
        else{
            $message = "Book returned successfully";
        }
    }
    else{
        $message = "Borrow record not found";
    }
}

?>
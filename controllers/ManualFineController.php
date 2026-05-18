<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/ManualFine.php";

$manualFineModel = new ManualFine($conn);

$message = "";

if(isset($_POST['save_fine'])){

    $borrow_record_id = $_POST['borrow_record_id'];
    $member_id = $_POST['member_id'];
    $branch_id = $_POST['branch_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];

    if($amount < 0){

        $message =
            "Fine amount cannot be negative";

    } else {

        if($manualFineModel->addFine(
            $borrow_record_id,
            $member_id,
            $branch_id,
            $amount,
            $reason
        )){
            $message =
                "Fine added successfully";
        }
        else{
            $message =
                "Failed to add fine";
        }
    }
}

?>
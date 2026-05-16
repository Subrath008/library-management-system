<?php

session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: ../views/librarian/login.php");
    exit();
}

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Borrow.php";

$borrowModel = new Borrow($conn);

if(isset($_GET['approve'])){

    $id = $_GET['approve'];

    $borrow_date = date("Y-m-d");
    $due_date = date("Y-m-d", strtotime("+14 days"));

    if($borrowModel->approveBorrow($id, $borrow_date, $due_date)){
        header("Location: ../views/librarian/borrow_requests.php?msg=approved");
        exit();
    }
}

if(isset($_POST['reject_borrow'])){

    $id = $_POST['borrow_id'];
    $reason = $_POST['rejection_reason'];

    if(empty($reason)){
        $reason = "No reason provided";
    }

    if($borrowModel->rejectBorrow($id, $reason)){
        header("Location: ../views/librarian/borrow_requests.php?msg=rejected");
        exit();
    }
}

?>
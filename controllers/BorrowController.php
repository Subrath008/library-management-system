<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Borrow.php";

$borrowModel = new Borrow($conn);

if(isset($_GET['approve'])){

    $borrowModel->approveRequest(
        $_GET['approve']
    );

    header(
        "Location: ../views/librarian/borrow_requests.php"
    );

    exit();
}

if(isset($_GET['reject'])){

    $borrowModel->rejectRequest(
        $_GET['reject']
    );

    header(
        "Location: ../views/librarian/borrow_requests.php"
    );

    exit();
}

$result = $borrowModel->getPendingRequests();

?>
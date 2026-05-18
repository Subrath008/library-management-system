<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Fine.php";

$fineModel = new Fine($conn);

if(isset($_GET['pay_id'])){

    $id = $_GET['pay_id'];

    $fineModel->markPaid($id);

header("Location: ../../views/librarian/manage_fines.php");

    exit();
}

$result = $fineModel->getAllFines();

?>
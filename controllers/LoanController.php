<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Loan.php";

$loanModel = new Loan($conn);

$filter = "";

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
}

$result = $loanModel->getLoans($filter);

?>
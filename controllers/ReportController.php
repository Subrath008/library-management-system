<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Report.php";

$reportModel = new Report($conn);

$mostBorrowedResult = $reportModel->mostBorrowedBooks();
$neverBorrowedResult = $reportModel->neverBorrowedBooks();
$borrowsPerGenreResult = $reportModel->borrowsPerGenre();

?>
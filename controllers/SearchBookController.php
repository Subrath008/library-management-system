<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/SearchBook.php";

$searchModel = new SearchBook($conn);

$result = null;

if(isset($_GET['search'])){

    $keyword = $_GET['keyword'];

    $result = $searchModel->search($keyword);
}

?>
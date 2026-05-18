<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Member.php";

$memberModel = new Member($conn);

$result = null;

if(isset($_GET['search'])){

    $keyword = $_GET['keyword'];

    $result = $memberModel->searchMembers(
        $keyword
    );
}

?>
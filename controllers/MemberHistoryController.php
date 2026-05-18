<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/MemberHistory.php";

$historyModel = new MemberHistory($conn);

$member_id = $_GET['id'];

$member = $historyModel->getMember($member_id);
$loan_result = $historyModel->getLoans($member_id);
$fine_result = $historyModel->getFines($member_id);

?>
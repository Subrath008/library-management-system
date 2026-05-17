<?php
session_start();
include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$fine_id = $_GET['id'] ?? 0;

if (!hasPendingFinePaymentRequest($conn, $fine_id, $member_id)) {
    submitFinePaymentRequest($conn, $fine_id, $member_id);
}

header("Location: fines.php?payment=requested");
exit();
?>

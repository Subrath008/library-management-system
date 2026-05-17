<?php
session_start();
include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$borrow_record_id = $_GET['id'] ?? 0;

if (!hasPendingRenewalRequest($conn, $borrow_record_id, $member_id)) {
    submitRenewalRequest($conn, $borrow_record_id, $member_id);
}

header("Location: active_loans.php");
exit();
?>

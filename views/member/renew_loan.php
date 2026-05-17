<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include_once("../../controllers/MemberController.php");

requireMemberLogin();

$borrow_record_id = $_GET['id'] ?? 0;

renewLoan($conn, $borrow_record_id);

header("Location: active_loans.php");
exit();
?>


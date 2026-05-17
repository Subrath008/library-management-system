<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include_once("../../controllers/MemberController.php");

requireMemberLogin();

$fine_id = $_GET['id'] ?? 0;

payFine($conn, $fine_id);

header("Location: fines.php");
exit();
?>

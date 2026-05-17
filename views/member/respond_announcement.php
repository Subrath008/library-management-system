<?php
session_start();
include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$announcement_id = $_GET['id'] ?? 0;

if (isset($_POST['submit_response'])) {
    $response_text = trim($_POST['response_text']);

    if ($response_text != "") {
        submitAnnouncementResponse($conn, $announcement_id, $member_id, $response_text);

        header("Location: dashboard.php?response=sent");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Respond to Announcement</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>Respond to Announcement</h2>

<a href="dashboard.php" class="back-btn">
    Back to Dashboard
</a>


<br><br>

<form method="POST">
    <label>Your Response</label><br>
    <textarea name="response_text" rows="5" cols="50" required></textarea>

    <br><br>

    <button type="submit" name="submit_response">Submit Response</button>
</form>

</body>
</html>

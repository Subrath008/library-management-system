<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];

$notifications = getMemberNotifications($conn, $member_id);

markNotificationsAsRead($conn, $member_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Notifications</h2>

<a href="dashboard.php" class="back-btn">
    Back to Dashboard
</a>


<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Message</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($notifications)) { ?>
        <tr>
            <td><?php echo $row['message']; ?></td>
            <td>
                <?php echo ($row['is_read'] == 1) ? "Read" : "Unread"; ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>

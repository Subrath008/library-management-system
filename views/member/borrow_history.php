<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$history = getBorrowHistory($conn, $_SESSION['member_id']);
?>

<!DOCTYPE html>
<html>
<head>
   <div class="topbar">

    <div class="topbar-left">
        <a href="dashboard.php" class="top-btn dashboard-btn">
            Dashboard
        </a>
    </div>

    <div class="topbar-right">
        <a href="logout.php" class="top-btn logout-top-btn">
            Logout
        </a>
    </div>

</div>


    <title>Borrow History</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Borrow History</h2>



<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Book Title</th>
        <th>Branch</th>
        <th>Status</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Return Date</th>
        <th>Renewals</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($history)) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['branch_name']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['borrow_date']; ?></td>
            <td><?php echo $row['due_date']; ?></td>
            <td><?php echo $row['return_date']; ?></td>
            <td><?php echo $row['renewals_count']; ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>

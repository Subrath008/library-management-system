<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$reservations = getMemberReservations($conn, $member_id);


$sql = "SELECT reservations.*, books.title, books.author, branches.name AS branch_name
        FROM reservations
        JOIN books ON reservations.book_id = books.id
        JOIN branches ON reservations.branch_id = branches.id
        WHERE reservations.member_id = ?
        ORDER BY reservations.reserved_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $member_id);
mysqli_stmt_execute($stmt);
$reservations = mysqli_stmt_get_result($stmt);
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



    <title>My Reservations</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Reservations</h2>


<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Book</th>
        <th>Author</th>
        <th>Branch</th>
        <th>Reserved At</th>
        <th>Status</th>
        <th>Queue Position</th>

    </tr>

    <?php while($row = mysqli_fetch_assoc($reservations)) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['branch_name']; ?></td>
            <td><?php echo $row['reserved_at']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
    <?php
    if ($row['status'] == 'waiting') {
        $position = getReservationPosition(
            $conn,
            $row['id'],
            $row['book_id'],
            $row['branch_id']
        );

        echo $position['position'];
    } else {
        echo "-";
    }
    ?>
</td>

 </tr>
    <?php } ?>

</table>

</body>
</html>

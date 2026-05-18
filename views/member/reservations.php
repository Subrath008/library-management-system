<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$reservations = getMemberReservations($conn, $member_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Reservations</title>
    <link rel="stylesheet" href="../../assets/css/member.css">
</head>

<body>

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

<h2>My Reservations</h2>

<table>
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


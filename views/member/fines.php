<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$fines = getMemberFines($conn, $_SESSION['member_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Fines</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Fines</h2>

<a href="dashboard.php" class="back-btn">
    Back to Dashboard
</a>


<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Book Title</th>
        <th>Amount</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Paid At</th>
        <th>Action</th>
    </tr>

    <?php while($fine = mysqli_fetch_assoc($fines)) { ?>
        <tr>
    <td><?php echo $fine['title']; ?></td>
    <td>$<?php echo number_format($fine['amount'], 2); ?></td>
    <td><?php echo $fine['reason']; ?></td>

    <td>
        <?php
        if ($fine['is_paid'] == 1) {
            echo "Paid";
        } else {
            echo "Unpaid";
        }
        ?>
    </td>

    <td><?php echo $fine['paid_at']; ?></td>

    <td>
        <?php if ($fine['is_paid'] == 0) { ?>
            <a href="pay_fine.php?id=<?php echo $fine['id']; ?>">
                Submit Payment Confirmation
            </a>
        <?php } else { ?>
            No Action
        <?php } ?>
    </td>

</tr>

    <?php } ?>

</table>

</body>
</html>

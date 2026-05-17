<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$loans = getActiveLoans($conn, $_SESSION['member_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Active Loans</title>
    
   <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Active Loans</h2>

<a href="dashboard.php" class="back-btn">
    Back to Dashboard
</a>


<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Book Title</th>
        <th>Branch</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Days Remaining</th>
        <th>Status</th>
        <th>Renew</th>
    </tr>

    <?php while($loan = mysqli_fetch_assoc($loans)) { 
        
        $today = date("Y-m-d");
        $due_date = $loan['due_date'];
        $days_remaining = (strtotime($due_date) - strtotime($today)) / 86400;
    ?>

    <tr>
        <td><?php echo $loan['title']; ?></td>
        <td><?php echo $loan['branch_name']; ?></td>
        <td><?php echo $loan['borrow_date']; ?></td>
        <td><?php echo $loan['due_date']; ?></td>

        <td>
            <?php if ($days_remaining < 0) { ?>
                <span style="color:red;">
                    Overdue by <?php echo abs($days_remaining); ?> days
                </span>
            <?php } else { ?>
                <?php echo $days_remaining; ?> days left
            <?php } ?>
        </td>

        <td><?php echo $loan['status']; ?></td>

        <td>
            <?php if ($loan['renewals_count'] < 2) { ?>
                <a href="renew_loan.php?id=<?php echo $loan['id']; ?>">
                    Request Renewal
                </a>
            <?php } else { ?>
                Max renewal reached
            <?php } ?>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>

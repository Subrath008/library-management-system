<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/LoanController.php";

$today = date("Y-m-d");
?>


<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>


<h2>Active Loans</h2>
<a href="active_loans.php">All</a> |
<a href="active_loans.php?filter=overdue">Overdue</a> |
<a href="active_loans.php?filter=today">Due Today</a> |
<a href="active_loans.php?filter=week">Due This Week</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Member ID</th>
        <th>Book</th>
        <th>Branch ID</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Status</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            <td><?php echo $row['borrow_date']; ?></td>

            <td>
                <?php
                if($row['due_date'] < $today){
                    echo "<span style='color:red; font-weight:bold;'>" . $row['due_date'] . " Overdue</span>";
                } else {
                    echo $row['due_date'];
                }
                ?>
            </td>

            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php } ?>
</table>

<br>

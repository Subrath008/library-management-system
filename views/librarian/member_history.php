<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/MemberHistoryController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>


<h2>Member Full History</h2>

<?php if($member){ ?>
<p><b>Name:</b> <?php echo $member['name']; ?></p>
<p><b>Email:</b> <?php echo $member['email']; ?></p>
<p><b>Phone:</b> <?php echo $member['phone']; ?></p>
<p><b>Branch ID:</b> <?php echo $member['branch_id']; ?></p>

<h3>Loan History</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Record ID</th>
        <th>Book</th>
        <th>Status</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Return Date</th>
    </tr>

    <?php while($loan = $loan_result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $loan['id']; ?></td>
            <td><?php echo $loan['title']; ?></td>
            <td><?php echo $loan['status']; ?></td>
            <td><?php echo $loan['borrow_date']; ?></td>
            <td><?php echo $loan['due_date']; ?></td>
            <td><?php echo $loan['return_date']; ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Fine History</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Fine ID</th>
        <th>Amount</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Paid At</th>
    </tr>

    <?php while($fine = $fine_result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $fine['id']; ?></td>
            <td><?php echo $fine['amount']; ?></td>
            <td><?php echo $fine['reason']; ?></td>
            <td><?php echo $fine['is_paid'] == 1 ? "Paid" : "Unpaid"; ?></td>
            <td><?php echo $fine['paid_at']; ?></td>
        </tr>
    <?php } ?>
</table>

<?php } else { ?>
<p>Member not found.</p>
<?php } ?>

<br>
<a href="search_members.php">Back to Member Search</a>
<br><br>

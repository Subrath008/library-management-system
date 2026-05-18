<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/BorrowController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>

<h2>Pending Borrow Requests</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Member ID</th>
        <th>Book</th>
        <th>Branch ID</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>

    <a href="../../controllers/BorrowController.php?approve=<?php echo $row['id']; ?>">
        Approve
    </a>

    <br><br>

    <form method="POST" action="../../controllers/BorrowController.php">

        <input type="hidden" name="borrow_id" value="<?php echo $row['id']; ?>">

        <input type="text" name="rejection_reason" placeholder="Reject reason">

        <button type="submit" name="reject_borrow">
            Reject
        </button>

    </form>

</td>
        </tr>
    <?php } ?>
</table>

<br>

<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

if(isset($_GET['approve'])){
    $id = $_GET['approve'];

    $borrow_date = date("Y-m-d");
    $due_date = date("Y-m-d", strtotime("+14 days"));

    $stmt = $conn->prepare(
        "UPDATE borrow_records 
         SET status='active', borrow_date=?, due_date=? 
         WHERE id=?"
    );
    $stmt->bind_param("ssi", $borrow_date, $due_date, $id);
    $stmt->execute();

    header("Location: borrow_requests.php");
    exit();
}

if(isset($_GET['reject'])){
    $id = $_GET['reject'];

    $stmt = $conn->prepare(
        "UPDATE borrow_records 
         SET status='rejected' 
         WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: borrow_requests.php");
    exit();
}

/*$result = $conn->query(
    "SELECT borrow_records.*, books.title 
     FROM borrow_records
     JOIN books ON borrow_records.book_id = books.id
     WHERE borrow_records.status='pending'
     ORDER BY borrow_records.id DESC"
);*/

$result = $conn->query(
    "SELECT borrow_records.*, books.title 
     FROM borrow_records
     LEFT JOIN books ON borrow_records.book_id = books.id
     WHERE borrow_records.status='pending'
     ORDER BY borrow_records.id DESC"
);
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">
<div style="margin-bottom:20px;">
    <a href="dashboard.php"
       style="
       background:#0b5ed7;
       color:white;
       padding:10px 15px;
       border-radius:5px;
       text-decoration:none;">
       ← Back to Dashboard
    </a>
</div>
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

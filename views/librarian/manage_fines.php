<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}


include "../../config/db.php";

if(isset($_GET['pay_id'])){
    $id = $_GET['pay_id'];
    $paid_at = date("Y-m-d H:i:s");

    $stmt = $conn->prepare(
        "UPDATE fines 
         SET is_paid=1, paid_at=? 
         WHERE id=?"
    );
    $stmt->bind_param("si", $paid_at, $id);
    $stmt->execute();

    header("Location: manage_fines.php");
    exit();
}

$result = $conn->query(
    "SELECT * FROM fines ORDER BY id DESC"
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
<h2>Manage Fines</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Borrow Record ID</th>
        <th>Member ID</th>
        <th>Branch ID</th>
        <th>Amount</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Paid At</th>
        <th>Action</th>
    </tr>

    <?php while($fine = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $fine['id']; ?></td>
            <td><?php echo $fine['borrow_record_id']; ?></td>
            <td><?php echo $fine['member_id']; ?></td>
            <td><?php echo $fine['branch_id']; ?></td>
            <td><?php echo $fine['amount']; ?></td>
            <td><?php echo $fine['reason']; ?></td>

            <td>
                <?php 
                if($fine['is_paid'] == 1){
                    echo "Paid";
                } else {
                    echo "Unpaid";
                }
                ?>
            </td>

            <td><?php echo $fine['paid_at']; ?></td>

            <td>
                <?php if($fine['is_paid'] == 0){ ?>
                    <a href="manage_fines.php?pay_id=<?php echo $fine['id']; ?>"
                       onclick="return confirm('Mark this fine as paid?')">
                       Mark as Paid
                    </a>
                <?php } else { ?>
                    Completed
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<br>

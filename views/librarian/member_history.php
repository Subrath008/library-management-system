<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
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
include "../../config/db.php";

$member_id = $_GET['id'];

$stmt = $conn->prepare("SELECT id, name, email, phone, branch_id FROM users WHERE id=? AND role='member'");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();

$loans = $conn->prepare(
    "SELECT borrow_records.*, books.title
     FROM borrow_records
     LEFT JOIN books ON borrow_records.book_id = books.id
     WHERE borrow_records.member_id=?
     ORDER BY borrow_records.id DESC"
);
$loans->bind_param("i", $member_id);
$loans->execute();
$loan_result = $loans->get_result();

$fines = $conn->prepare(
    "SELECT * FROM fines
     WHERE member_id=?
     ORDER BY id DESC"
);
$fines->bind_param("i", $member_id);
$fines->execute();
$fine_result = $fines->get_result();
?>

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

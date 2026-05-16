<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

$message = "";

if(isset($_POST['issue_fine'])){

    $borrow_record_id = $_POST['borrow_record_id'];
    $member_id = $_POST['member_id'];
    $branch_id = $_POST['branch_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare(
        "INSERT INTO fines 
        (borrow_record_id, member_id, branch_id, amount, reason, is_paid)
        VALUES (?, ?, ?, ?, ?, 0)"
    );

    $stmt->bind_param(
        "iiids",
        $borrow_record_id,
        $member_id,
        $branch_id,
        $amount,
        $reason
    );

    if($stmt->execute()){
        $message = "Manual fine issued successfully";
    } else {
        $message = "Failed to issue fine";
    }
}
?>

<h2>Issue Manual Fine</h2>

<p style="color:green;"><?php echo $message; ?></p>

<form method="POST">

    <input type="number" name="borrow_record_id" placeholder="Borrow Record ID" required>
    <br><br>

    <input type="number" name="member_id" placeholder="Member ID" required>
    <br><br>

    <input type="number" name="branch_id" placeholder="Branch ID" value="1" required>
    <br><br>

    <input type="number" step="0.01" name="amount" placeholder="Fine Amount" required>
    <br><br>

    <select name="reason" required>
        <option value="">Select Reason</option>
        <option value="Damaged book fine">Damaged book fine</option>
        <option value="Lost book fine">Lost book fine</option>
        <option value="Other manual fine">Other manual fine</option>
    </select>
    <br><br>

    <button type="submit" name="issue_fine">Issue Fine</button>

</form>

<br>
<a href="manage_fines.php">View Fines</a>
<br><br>
<a href="dashboard.php">Back to Dashboard</a>
<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

$message = "";
$today = date("Y-m-d");
$fine_rate = 5;

if(isset($_GET['return_id'])){
    $id = $_GET['return_id'];

    $stmt = $conn->prepare("SELECT * FROM borrow_records WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();

    if($record){
        $return_date = $today;

        $update = $conn->prepare(
            "UPDATE borrow_records 
             SET status='returned', return_date=? 
             WHERE id=?"
        );
        $update->bind_param("si", $return_date, $id);
        $update->execute();

        if($record['due_date'] < $today){
            $days_late = (strtotime($today) - strtotime($record['due_date'])) / 86400;
            $amount = $days_late * $fine_rate;
            $reason = "Overdue fine for " . $days_late . " days";

            $fine = $conn->prepare(
                "INSERT INTO fines 
                (borrow_record_id, member_id, branch_id, amount, reason)
                VALUES (?, ?, ?, ?, ?)"
            );
            $fine->bind_param(
                "iiids",
                $id,
                $record['member_id'],
                $record['branch_id'],
                $amount,
                $reason
            );
            $fine->execute();
        }

        $message = "Book returned successfully";
    }
}

$result = $conn->query(
    "SELECT borrow_records.*, books.title
     FROM borrow_records
     LEFT JOIN books ON borrow_records.book_id = books.id
     WHERE borrow_records.status='active'
     ORDER BY borrow_records.due_date ASC"
);
?>

<h2>Process Book Returns</h2>

<p><?php echo $message; ?></p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Member ID</th>
        <th>Book</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['borrow_date']; ?></td>
            <td><?php echo $row['due_date']; ?></td>
            <td>
                <a href="process_return.php?return_id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Mark this book as returned?')">
                   Return
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>
<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

$today = date("Y-m-d");
$filter = "";

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
}

if($filter == "overdue"){

    $stmt = $conn->prepare(
        "SELECT borrow_records.*, books.title
         FROM borrow_records
         LEFT JOIN books ON borrow_records.book_id = books.id
         WHERE borrow_records.status='active'
         AND borrow_records.due_date < ?
         ORDER BY borrow_records.due_date ASC"
    );

    $stmt->bind_param("s", $today);

} elseif($filter == "today"){

    $stmt = $conn->prepare(
        "SELECT borrow_records.*, books.title
         FROM borrow_records
         LEFT JOIN books ON borrow_records.book_id = books.id
         WHERE borrow_records.status='active'
         AND borrow_records.due_date = ?
         ORDER BY borrow_records.due_date ASC"
    );

    $stmt->bind_param("s", $today);

} elseif($filter == "week"){

    $week_later = date("Y-m-d", strtotime("+7 days"));

    $stmt = $conn->prepare(
        "SELECT borrow_records.*, books.title
         FROM borrow_records
         LEFT JOIN books ON borrow_records.book_id = books.id
         WHERE borrow_records.status='active'
         AND borrow_records.due_date BETWEEN ? AND ?
         ORDER BY borrow_records.due_date ASC"
    );

    $stmt->bind_param("ss", $today, $week_later);

} else {

    $stmt = $conn->prepare(
        "SELECT borrow_records.*, books.title
         FROM borrow_records
         LEFT JOIN books ON borrow_records.book_id = books.id
         WHERE borrow_records.status='active'
         ORDER BY borrow_records.due_date ASC"
    );
}

$stmt->execute();
$result = $stmt->get_result();
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

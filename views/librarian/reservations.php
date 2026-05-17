<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

if(isset($_GET['fulfill'])){
    $id = $_GET['fulfill'];

    $stmt = $conn->prepare(
        "UPDATE reservations SET status='fulfilled' WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: reservations.php?msg=fulfilled");
    exit();
}

$result = $conn->prepare(
    "SELECT reservations.*, books.title
     FROM reservations
     LEFT JOIN books ON reservations.book_id = books.id
     WHERE reservations.status='waiting'
     ORDER BY reservations.reserved_at ASC"
);
$result->execute();
$reservations = $result->get_result();
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>

<h2>Reservation Waitlist</h2>

<?php
if(isset($_GET['msg'])){
    echo "<p style='color:green;'>Reservation fulfilled successfully</p>";
}
?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Member ID</th>
        <th>Book</th>
        <th>Branch ID</th>
        <th>Reserved At</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $reservations->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            <td><?php echo $row['reserved_at']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="reservations.php?fulfill=<?php echo $row['id']; ?>"
                   onclick="return confirm('Fulfil this reservation?')">
                   Fulfil
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<br>

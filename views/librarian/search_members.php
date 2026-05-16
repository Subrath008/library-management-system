<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

$keyword = "";
$members = null;

if(isset($_GET['search'])){
    $keyword = $_GET['keyword'];
    $like = "%" . $keyword . "%";

    $stmt = $conn->prepare(
        "SELECT id, name, email, phone, role, branch_id
         FROM users
         WHERE role='member'
         AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)"
    );

    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $members = $stmt->get_result();
}
?>

<h2>Search Member Records</h2>

<form method="GET">
    <input type="text" name="keyword" placeholder="Search by name, email, or phone" required>
    <button type="submit" name="search">Search</button>
</form>

<br>

<?php if($members){ ?>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Branch ID</th>
        <th>Action</th>
    </tr>

    <?php while($member = $members->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $member['id']; ?></td>
            <td><?php echo $member['name']; ?></td>
            <td><?php echo $member['email']; ?></td>
            <td><?php echo $member['phone']; ?></td>
            <td><?php echo $member['branch_id']; ?></td>
            <td>
                <a href="member_history.php?id=<?php echo $member['id']; ?>">View History</a>
            </td>
        </tr>
    <?php } ?>
</table>
<?php } ?>

<br>
<a href="dashboard.php">Back to Dashboard</a>
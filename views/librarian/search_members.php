<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/MemberController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>

<h2>Search Member Records</h2>

<form method="GET">
    <input type="text" name="keyword" placeholder="Search by name, email, or phone" required>
    <button type="submit" name="search">Search</button>
</form>

<br>

<?php if($result){ ?>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Branch ID</th>
        <th>Action</th>
    </tr>

  <?php while($member = $result->fetch_assoc()){ ?>
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

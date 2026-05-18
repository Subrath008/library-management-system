<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/ReportController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>

<h2>Catalog Statistics</h2>

<h3>Most Borrowed Books</h3>

<table border="1" cellpadding="10">

    <tr>
        <th>Book Title</th>
        <th>Total Borrows</th>
    </tr>

    <?php while($row = $mostBorrowedResult->fetch_assoc()){ ?>

        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['total_borrows']; ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<h3>Books Never Borrowed</h3>

<table border="1" cellpadding="10">

    <tr>
        <th>Book ID</th>
        <th>Title</th>
        <th>Author</th>
    </tr>

    <?php while($row = $neverBorrowedResult->fetch_assoc()){ ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<h3>Total Borrows Per Genre</h3>

<table border="1" cellpadding="10">

    <tr>
        <th>Genre</th>
        <th>Total Borrows</th>
    </tr>

    <?php while($row = $borrowsPerGenreResult->fetch_assoc()){ ?>

        <tr>
            <td><?php echo $row['genre_name']; ?></td>
            <td><?php echo $row['total_borrows']; ?></td>
        </tr>

    <?php } ?>

</table>
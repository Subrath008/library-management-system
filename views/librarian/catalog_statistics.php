<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

/* Most borrowed books */
$mostBorrowed = $conn->prepare(
    "SELECT books.title, COUNT(borrow_records.id) AS total_borrows
     FROM borrow_records
     JOIN books ON borrow_records.book_id = books.id
     GROUP BY books.id, books.title
     ORDER BY total_borrows DESC"
);
$mostBorrowed->execute();
$mostBorrowedResult = $mostBorrowed->get_result();

/* Never borrowed books */
$neverBorrowed = $conn->prepare(
    "SELECT books.id, books.title, books.author
     FROM books
     LEFT JOIN borrow_records ON books.id = borrow_records.book_id
     WHERE borrow_records.id IS NULL"
);
$neverBorrowed->execute();
$neverBorrowedResult = $neverBorrowed->get_result();

/* Total borrows per genre */
$borrowsPerGenre = $conn->prepare(
    "SELECT genres.name AS genre_name, COUNT(borrow_records.id) AS total_borrows
     FROM genres
     LEFT JOIN books ON genres.id = books.genre_id
     LEFT JOIN borrow_records ON books.id = borrow_records.book_id
     GROUP BY genres.id, genres.name
     ORDER BY total_borrows DESC"
);
$borrowsPerGenre->execute();
$borrowsPerGenreResult = $borrowsPerGenre->get_result();
?>

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

<br>
<a href="dashboard.php">Back to Dashboard</a>
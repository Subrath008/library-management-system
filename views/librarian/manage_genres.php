<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";
include "../../models/Genre.php";

$genreModel = new Genre($conn);
$result = $genreModel->getAllGenres();
?>

<h2>Manage Genres</h2>

<?php
if(isset($_GET['msg'])){
    echo "<p style='color:green;'>Action completed successfully</p>";
}

if(isset($_GET['error']) && $_GET['error'] == "genre_used"){
    echo "<p style='color:red;'>Cannot delete this genre because books are assigned to it.</p>";
}
?>

<form method="POST" action="../../controllers/GenreController.php">
    <input type="text" name="name" placeholder="Genre Name" required>
    <button type="submit" name="add_genre">Add Genre</button>
</form>

<br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Genre Name</th>
        <th>Action</th>
    </tr>

    <?php while($genre = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $genre['id']; ?></td>
            <td><?php echo $genre['name']; ?></td>
            <td>
                <a href="edit_genre.php?id=<?php echo $genre['id']; ?>">Edit</a> |
                <a href="../../controllers/GenreController.php?delete=<?php echo $genre['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>
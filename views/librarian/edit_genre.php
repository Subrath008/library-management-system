<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";
include "../../models/Genre.php";

$genreModel = new Genre($conn);
$genre = $genreModel->getGenreById($_GET['id']);
?>

<h2>Edit Genre</h2>

<?php
if(isset($_GET['error'])){
    echo "<p style='color:red;'>Failed to update genre</p>";
}
?>

<form method="POST" action="../../controllers/GenreController.php">

    <input type="hidden" name="id" value="<?php echo $genre['id']; ?>">

    <input type="text" name="name" value="<?php echo $genre['name']; ?>" required>

    <button type="submit" name="update_genre">Update Genre</button>

</form>

<br>
<a href="manage_genres.php">Back</a>
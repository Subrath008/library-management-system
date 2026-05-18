<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}


include "../../config/db.php";
include "../../models/Book.php";

$bookModel = new Book($conn);
$book = $bookModel->getBookById($_GET['id']);
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>
<h2>Edit Book</h2>

<?php
if(isset($_GET['error'])){
    echo "<p style='color:red;'>Failed to update book</p>";
}
?>
<a href="view_books.php">Back to Books</a>
<form method="POST" action="../../controllers/BookController.php" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
    <input type="hidden" name="old_cover_image" value="<?php echo $book['cover_image_path']; ?>">

    <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
    <br><br>

    <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
    <br><br>

    <input type="text" name="isbn" value="<?php echo $book['isbn']; ?>">
    <br><br>

    <input type="number" name="genre_id" value="<?php echo $book['genre_id']; ?>" min="1">
    <br><br>

    <input type="text" name="publisher" value="<?php echo $book['publisher']; ?>">
    <br><br>

   <input type="number" name="published_year" value="<?php echo $book['published_year']; ?>" min="1000" max="2026">
    <br><br>

    <textarea name="description"><?php echo $book['description']; ?></textarea>
    <br><br>

    <?php if(!empty($book['cover_image_path'])){ ?>
        <img src="../../<?php echo $book['cover_image_path']; ?>" width="100">
        <br><br>
    <?php } ?>

    <label>Change Cover Image:</label>
    <input type="file" name="cover_image" accept="image/*">
    <br><br>

    <button type="submit" name="update_book">Update Book</button>

</form>

<br>


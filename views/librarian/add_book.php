<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>


<h2>Add New Book</h2>

<?php
if(isset($_GET['error'])){
    echo "<p style='color:red;'>Failed to add book</p>";
}
?>

<form method="POST" action="../../controllers/BookController.php" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Book Title" required>
    <br><br>

    <input type="text" name="author" placeholder="Author Name" required>
    <br><br>

    <input type="text" name="isbn" placeholder="ISBN">
    <br><br>

    <input type="number" name="genre_id" placeholder="Genre ID" min="1">
    <br><br>

    <input type="text" name="publisher" placeholder="Publisher">
    <br><br>

    <input type="number" name="published_year" placeholder="Published Year" min="1000" max="2026">
    <br><br>

    <textarea name="description" placeholder="Book Description"></textarea>
    <br><br>

    <label>Cover Image:</label>
    <input type="file" name="cover_image" accept="image/*">
    <br><br>

    <button type="submit" name="add_book">Add Book</button>

</form>

<br>

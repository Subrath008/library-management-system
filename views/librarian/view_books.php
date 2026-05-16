<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";
include "../../models/Book.php";

$bookModel = new Book($conn);
$result = $bookModel->getAllBooks();
?>

<h2>All Books</h2>

<?php
if(isset($_GET['msg'])){
    echo "<p style='color:green;'>Action completed successfully</p>";
}
?>

<a href="add_book.php">Add New Book</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Cover</th>
        <th>Title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Genre ID</th>
        <th>Publisher</th>
        <th>Year</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

  <?php while($book = $result->fetch_assoc()){ ?>
<tr>

    <td><?php echo $book['id']; ?></td>

    <td>
        <?php if(!empty($book['cover_image_path'])){ ?>
            <img src="../../<?php echo $book['cover_image_path']; ?>" width="70">
        <?php } else { ?>
            No Image
        <?php } ?>
    </td>

    <td><?php echo $book['title']; ?></td>
    <td><?php echo $book['author']; ?></td>
    <td><?php echo $book['isbn']; ?></td>
    <td><?php echo $book['genre_id']; ?></td>
    <td><?php echo $book['publisher']; ?></td>
    <td><?php echo $book['published_year']; ?></td>

    <td>
        <?php
        if($book['is_available'] == 1){
            echo "Available";
        } else {
            echo "<span style='color:red;'>Unavailable</span>";
        }
        ?>
    </td>

    <td>

        <?php if($book['is_available'] == 1){ ?>

            <a href="edit_book.php?id=<?php echo $book['id']; ?>">Edit</a> |

            <a href="../../controllers/BookController.php?unavailable=<?php echo $book['id']; ?>"
               onclick="return confirm('Mark this book unavailable?')">
               Mark Unavailable
            </a>

        <?php } else { ?>

            <span style="color:red; font-weight:bold;">
                Unavailable
            </span>

        <?php } ?>

    </td>

</tr>
<?php } ?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>
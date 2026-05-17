<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}


include "../../config/db.php";

$message = "";

if(isset($_POST['save_inventory'])){

    $book_id = $_POST['book_id'];
    $branch_id = $_POST['branch_id'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    if($total_copies < 0 || $available_copies < 0){

        $message = "Copies cannot be negative";

    } elseif($available_copies > $total_copies){

        $message = "Available copies cannot be more than total copies";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO branch_inventory 
            (book_id, branch_id, total_copies, available_copies)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiii",
            $book_id,
            $branch_id,
            $total_copies,
            $available_copies
        );

        if($stmt->execute()){
            $message = "Inventory added successfully";
        } else {
            $message = "Failed to add inventory";
        }
    }
}
$books = $conn->query("SELECT id, title FROM books ORDER BY title ASC");

$inventory = $conn->query(
    "SELECT branch_inventory.*, books.title 
     FROM branch_inventory
     JOIN books ON branch_inventory.book_id = books.id
     ORDER BY branch_inventory.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="../../assets/css/librarian.css">
    <?php include "navbar.php"; ?>
    
</head>
<body>

<h2>Manage Branch Inventory</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <label>Select Book:</label>
    <select name="book_id" required>
        <option value="">Select Book</option>
        <?php while($book = $books->fetch_assoc()){ ?>
            <option value="<?php echo $book['id']; ?>">
                <?php echo $book['title']; ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

  <input type="number" name="branch_id" placeholder="Branch ID" min="1" required>
    <br><br>

    <input type="number" name="total_copies" placeholder="Total Copies" min="0" required>
    <br><br>
    <input type="number" name="available_copies" placeholder="Available Copies" min="0" required>
   <br><br>
    <button type="submit" name="save_inventory">Save Inventory</button>

</form>  

<br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Book</th>
        <th>Branch ID</th>
        <th>Total Copies</th>
        <th>Available Copies</th>
    </tr>

    <?php while($row = $inventory->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            <td><?php echo $row['total_copies']; ?></td>
            <td><?php echo $row['available_copies']; ?></td>
        </tr>
    <?php } ?>
</table>

<br>


</body>
</html>
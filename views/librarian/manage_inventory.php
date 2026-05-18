<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/InventoryController.php";
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

    <?php while($book = $booksResult->fetch_assoc()){ ?>
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

    <?php while($row = $result->fetch_assoc()){ ?>
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
<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/ReturnController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>

<h2>Process Book Return</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <input type="number"
           name="borrow_record_id"
           placeholder="Borrow Record ID"
           min="1"
           required>

    <br><br>

    <button type="submit"
            name="return_book">
            Process Return
    </button>

</form>
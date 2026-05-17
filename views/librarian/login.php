<!DOCTYPE html>
<html>
<head>
    <title>Librarian Login</title>
</head>
<body>

<h2>Librarian Login</h2>

<?php
if(isset($_GET['error'])){
    echo "<p style='color:red;'>Invalid login information</p>";
}
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<form method="POST" action="../../controllers/AuthController.php">

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit" name="login">Login</button>

</form>

</body>
</html>
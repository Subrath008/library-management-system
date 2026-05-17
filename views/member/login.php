<?php
session_start();
include_once("../../controllers/MemberController.php");

$message = handleMemberLogin();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member Login</title>
    
   <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2> Login</h2>

<?php if ($message != "") { ?>
    <p style="color:red;"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<br>
<a href="register.php">Create new account</a>

</body>
</html>




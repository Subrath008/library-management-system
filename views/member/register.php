<?php
session_start();
include_once("../../controllers/MemberController.php");

$message = handleMemberRegister();
$branches = getAllBranches($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member Register</title>
    
   <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>Member Registration</h2>

<?php if ($message != "") { ?>
    <p style="color:red;"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">
    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Select Primary Branch</label><br>
    <select name="branch_id" required>
        <option value="">Select Branch</option>
        <?php while($branch = mysqli_fetch_assoc($branches)) { ?>
            <option value="<?php echo $branch['id']; ?>">
                <?php echo $branch['name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit" name="register">Register</button>
</form>

<br>
<a href="login.php">Already have an account? Login</a>

</body>
</html>

<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$profile_message = handleProfileUpdate();
$password_message = handlePasswordChange();
$picture_message = handleProfilePictureUpload();

$member = getMemberById($conn, $_SESSION['member_id']);
?>

<!DOCTYPE html>
<html>
<head>
<div class="topbar">

    <div class="topbar-left">
        <a href="dashboard.php" class="top-btn dashboard-btn">
            Dashboard
        </a>
    </div>

    <div class="topbar-right">
        <a href="logout.php" class="top-btn logout-top-btn">
            Logout
        </a>
    </div>

</div>





    <title>Member Profile</title>
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Profile</h2>



<br><br>

<?php if ($member['profile_pic'] != "") { ?>
    <img src="../../<?php echo $member['profile_pic']; ?>" width="120" height="120">



<?php } ?>

<h3>Profile Information</h3>

<?php if ($profile_message != "") echo "<p style='color:green;'>$profile_message</p>"; ?>

<form method="POST">
    <label>Name</label><br>
    <input type="text" name="name" value="<?php echo $member['name']; ?>" required><br><br>

    <label>Email</label><br>
    <input type="email" value="<?php echo $member['email']; ?>" disabled><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="<?php echo $member['phone']; ?>" required><br><br>

    <label>Primary Branch</label><br>
    <input type="text" value="<?php echo $member['branch_name']; ?>" disabled><br><br>

    <label>Status</label><br>
    <input type="text" value="<?php echo ($member['is_active'] == 1) ? 'Active' : 'Inactive'; ?>" disabled><br><br>

    <button type="submit" name="update_profile">Update Profile</button>
</form>

<hr>

<h3>Change Password</h3>

<?php if ($password_message != "") echo "<p style='color:green;'>$password_message</p>"; ?>

<form method="POST">
    <label>New Password</label><br>
    <input type="password" name="new_password" required><br><br>

    <button type="submit" name="change_password">Change Password</button>
</form>

<hr>

<h3>Upload Profile Picture</h3>

<?php if ($picture_message != "") echo "<p style='color:green;'>$picture_message</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic" accept="image/*" required><br><br>

    <button type="submit" name="upload_picture">Upload Picture</button>
</form>

</body>
</html>

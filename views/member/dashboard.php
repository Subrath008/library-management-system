<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");



include_once("../../controllers/MemberController.php");

requireMemberLogin();

include_once("../../config/db.php");
include_once("../../models/MemberModel.php");

$member = getMemberById($conn, $_SESSION['member_id']);

$announcements = getAnnouncementsForMember(
    $conn,
    $_SESSION['member_branch_id']
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>
   
<link rel="stylesheet" href="../../assets/css/member.css">

    <style>

        body{
            font-family: Arial;
            margin:20px;
            background:#f4f4f4;
        }

        .container{
            display:flex;
        }

        .sidebar{
            width:250px;
            background:#222;
            min-height:100vh;
            padding:20px;
        }

        .sidebar h2{
            color:white;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:10px;
            margin-bottom:10px;
            background:#333;
        }

        .sidebar a:hover{
            background:#007bff;
        }

        .content{
            flex:1;
            padding:20px;
            background:white;
        }

        .announcement{
            border:1px solid #ccc;
            padding:15px;
            margin-bottom:15px;
            background:#fafafa;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="sidebar">

        <h2>Member Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="browse_books.php">Browse Books</a>

        <a href="active_loans.php">Active Loans</a>

        <a href="borrow_history.php">Borrow History</a>

        <a href="reading_list.php">Reading List</a>

        <a href="fines.php">Fines</a>

        <a href="profile.php">Profile</a>

        <a href="reservations.php">Reservations</a>

        

         
        
      <?php
$notification_sql = "SELECT COUNT(*) AS total
                     FROM notifications
                     WHERE member_id = ?
                     AND is_read = 0";

$notification_stmt = mysqli_prepare($conn, $notification_sql);

mysqli_stmt_bind_param(
    $notification_stmt,
    "i",
    $_SESSION['member_id']
);

mysqli_stmt_execute($notification_stmt);

$notification_result = mysqli_stmt_get_result($notification_stmt);

$notification_count = mysqli_fetch_assoc($notification_result);
?>

<a href="notifications.php">
    Notifications
    <?php if ($notification_count['total'] > 0) { ?>
        (<?php echo $notification_count['total']; ?>)
    <?php } ?>

</a>

<a href="logout.php" class="logout-btn">
        Logout
       </a>



    </div>

    <div class="content">

        <h1>
            Welcome,
            <?php echo $_SESSION['member_name']; ?>
        </h1>

        <p>
            Primary Branch:
            <strong>
                <?php echo $member['branch_name']; ?>
            </strong>
        </p>

        <hr>

        <h2>Branch Announcements</h2>

        <?php while($announcement = mysqli_fetch_assoc($announcements)) { ?>

            <div class="announcement">

                <h3>
                    <?php echo $announcement['title']; ?>
                </h3>

                <p>
                    <?php echo $announcement['body']; ?>
                </p>

                <small>
                    Posted:
                    <?php echo $announcement['published_at']; ?>
                </small>
                <br><br>
             <a href="respond_announcement.php?id=<?php echo $announcement['id']; ?>">
             Respond
             </a>


            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>

<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

handleRemoveReadingList();

$reading_list = getReadingList($conn, $_SESSION['member_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reading List</title>
    
   <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>My Reading List</h2>

<a href="dashboard.php" class="back-btn">
    Back to Dashboard
</a>


<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Book Title</th>
        <th>Author</th>
        <th>Added At</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($reading_list)) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['added_at']; ?></td>
            <td>
                <a href="reading_list.php?remove_book=<?php echo $row['book_id']; ?>"
                   onclick="return confirm('Remove this book from reading list?');">
                    Remove
                </a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>




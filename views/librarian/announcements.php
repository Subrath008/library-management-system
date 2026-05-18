<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/AnnouncementController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>

<h2>Post Announcement</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <input type="number"
           name="branch_id"
           placeholder="Branch ID"
           value="1"
           min="1"
           required>

    <br><br>

    <input type="text"
           name="title"
           placeholder="Announcement Title"
           required>

    <br><br>

    <textarea name="body"
              placeholder="Announcement Body"
              required></textarea>

    <br><br>

    <button type="submit"
            name="post_announcement">
            Post Announcement
    </button>

</form>

<br>

<h2>All Announcements</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Branch ID</th>
        <th>Title</th>
        <th>Body</th>
        <th>Published At</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['body']; ?></td>
            <td><?php echo $row['published_at']; ?></td>
        </tr>

    <?php } ?>

</table>
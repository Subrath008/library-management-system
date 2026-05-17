<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../config/db.php";

$message = "";

if(isset($_POST['post_announcement'])){

    $branch_id = $_POST['branch_id'];
    $author_id = 1;
    $title = $_POST['title'];
    $body = $_POST['body'];

    $stmt = $conn->prepare(
        "INSERT INTO announcements (branch_id, author_id, title, body)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("iiss", $branch_id, $author_id, $title, $body);

    if($stmt->execute()){
        $message = "Announcement posted successfully";
    } else {
        $message = "Failed to post announcement";
    }
}

$result = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<div style="margin-bottom:20px;">
    <a href="dashboard.php"
       style="
       background:#0b5ed7;
       color:white;
       padding:10px 15px;
       border-radius:5px;
       text-decoration:none;">
       ← Back to Dashboard
    </a>
</div>

<h2>Post Announcement</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <input type="number" name="branch_id" placeholder="Branch ID" value="1" required>
    <br><br>

    <input type="text" name="title" placeholder="Announcement Title" required>
    <br><br>

    <textarea name="body" placeholder="Announcement Body" required></textarea>
    <br><br>

    <button type="submit" name="post_announcement">Post Announcement</button>

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

<br>

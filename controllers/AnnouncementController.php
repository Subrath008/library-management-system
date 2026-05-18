<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Announcement.php";

$announcementModel = new Announcement($conn);

$message = "";

if(isset($_POST['post_announcement'])){

    $branch_id = $_POST['branch_id'];
    $author_id = 1;
    $title = $_POST['title'];
    $body = $_POST['body'];

    if($announcementModel->addAnnouncement(
        $branch_id,
        $author_id,
        $title,
        $body
    )){
        $message = "Announcement posted successfully";
    }
    else{
        $message = "Failed to post announcement";
    }
}

$result = $announcementModel->getAllAnnouncements();

?>
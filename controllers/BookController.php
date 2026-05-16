<?php

session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: ../views/librarian/login.php");
    exit();
}

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Book.php";

$bookModel = new Book($conn);

if(isset($_POST['add_book'])){

    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre_id = $_POST['genre_id'];
    $publisher = $_POST['publisher'];
    $published_year = $_POST['published_year'];
    $description = $_POST['description'];

    $cover_image_path = "";

    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0){

        $image_name = time() . "_" . $_FILES['cover_image']['name'];
        $target_path = __DIR__ . "/../assets/uploads/" . $image_name;

        if(move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_path)){
            $cover_image_path = "assets/uploads/" . $image_name;
        }
    }

    if($bookModel->addBook($title, $author, $isbn, $genre_id, $publisher, $published_year, $description, $cover_image_path)){
        header("Location: ../views/librarian/view_books.php?msg=added");
        exit();
    } else {
        header("Location: ../views/librarian/add_book.php?error=failed");
        exit();
    }
}

if(isset($_POST['update_book'])){

    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre_id = $_POST['genre_id'];
    $publisher = $_POST['publisher'];
    $published_year = $_POST['published_year'];
    $description = $_POST['description'];
    $old_cover_image = $_POST['old_cover_image'];

    $cover_image_path = $old_cover_image;

    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0){

        $image_name = time() . "_" . $_FILES['cover_image']['name'];
        $target_path = __DIR__ . "/../assets/uploads/" . $image_name;

        if(move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_path)){
            $cover_image_path = "assets/uploads/" . $image_name;
        }
    }

    if($bookModel->updateBook($id, $title, $author, $isbn, $genre_id, $publisher, $published_year, $description, $cover_image_path)){
        header("Location: ../views/librarian/view_books.php?msg=updated");
        exit();
    } else {
        header("Location: ../views/librarian/edit_book.php?id=$id&error=failed");
        exit();
    }
}

if(isset($_GET['unavailable'])){

    $id = $_GET['unavailable'];

    if($bookModel->markUnavailable($id)){
        header("Location: ../views/librarian/view_books.php?msg=unavailable");
        exit();
    } else {
        header("Location: ../views/librarian/view_books.php?error=unavailable_failed");
        exit();
    }
}


?>
<?php

session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: ../views/librarian/login.php");
    exit();
}

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Genre.php";

$genreModel = new Genre($conn);

if(isset($_POST['add_genre'])){

    $name = $_POST['name'];

    if($genreModel->addGenre($name)){
        header("Location: ../views/librarian/manage_genres.php?msg=added");
        exit();
    } else {
        header("Location: ../views/librarian/manage_genres.php?error=add_failed");
        exit();
    }
}

if(isset($_POST['update_genre'])){

    $id = $_POST['id'];
    $name = $_POST['name'];

    if($genreModel->updateGenre($id, $name)){
        header("Location: ../views/librarian/manage_genres.php?msg=updated");
        exit();
    } else {
        header("Location: ../views/librarian/edit_genre.php?id=$id&error=update_failed");
        exit();
    }
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    if($genreModel->isGenreUsed($id)){
        header("Location: ../views/librarian/manage_genres.php?error=genre_used");
        exit();
    }

    if($genreModel->deleteGenre($id)){
        header("Location: ../views/librarian/manage_genres.php?msg=deleted");
        exit();
    } else {
        header("Location: ../views/librarian/manage_genres.php?error=delete_failed");
        exit();
    }
}

?>
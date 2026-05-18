<?php

session_start();

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Auth.php";

$authModel = new Auth($conn);

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

   $result = $authModel->loginLibrarian($email);

    if($result->num_rows === 1){

        $user = $result->fetch_assoc();

        if($password == $user['password_hash']){

            $_SESSION['librarian'] = $user['name'];
            $_SESSION['librarian_id'] = $user['id'];
            $_SESSION['branch_id'] = $user['branch_id'];

            header("Location: ../views/librarian/dashboard.php");
            exit();

        } else {
            header("Location: ../views/librarian/login.php?error=wrong_password");
            exit();
        }

    } else {
        header("Location: ../views/librarian/login.php?error=user_not_found");
        exit();
    }
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: ../views/librarian/login.php");
    exit();
}

?>
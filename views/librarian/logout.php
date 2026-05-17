<?php

session_start();
<link rel="stylesheet" href="../../assets/css/librarian.css">
session_destroy();

header("Location: login.php");

?>
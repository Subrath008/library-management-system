<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "library_management_system"
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>




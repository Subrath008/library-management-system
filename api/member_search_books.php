<?php
header("Content-Type: application/json");

include_once("../config/db.php");
include_once("../models/MemberModel.php");

$keyword = $_GET['keyword'] ?? "";
$genre_id = $_GET['genre_id'] ?? "";
$branch_id = $_GET['branch_id'] ?? "";
$year = $_GET['year'] ?? "";

$books = searchBooks($conn, $keyword, $genre_id, $branch_id, $year);

$data = [];

while ($book = mysqli_fetch_assoc($books)) {
    $data[] = [
        "id" => $book["id"],
        "title" => $book["title"],
        "author" => $book["author"],
        "isbn" => $book["isbn"],
        "genre_name" => $book["genre_name"],
        "published_year" => $book["published_year"],
        "total_available" => $book["total_available"]
    ];
}

echo json_encode($data);
?>

<?php
header("Content-Type: application/json");

include "../config/db.php";

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$like = "%" . $search . "%";

$stmt = $conn->prepare(
    "SELECT id, title, author, isbn, publisher, published_year 
     FROM books 
     WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?
     ORDER BY id DESC"
);

$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();

$result = $stmt->get_result();

$books = [];

while($row = $result->fetch_assoc()){
    $books[] = $row;
}

echo json_encode($books);
?>
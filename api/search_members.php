<?php
header("Content-Type: application/json");

include "../config/db.php";

$keyword = "";

if(isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

$search = "%" . $keyword . "%";

$stmt = $conn->prepare(
    "SELECT id, name, email, phone, branch_id
     FROM users
     WHERE role='member'
     AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)
     ORDER BY id DESC"
);

$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();

$result = $stmt->get_result();

$members = [];

while($row = $result->fetch_assoc()){
    $members[] = $row;
}

echo json_encode($members);
?>
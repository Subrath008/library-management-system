<?php
session_start();
include_once("../../controllers/MemberController.php");

requireMemberLogin();

$member_id = $_SESSION['member_id'];
$review_id = $_GET['id'] ?? 0;

$review = getReviewById($conn, $review_id, $member_id);

if (!$review) {
    echo "Review not found or access denied.";
    exit();
}

if (isset($_POST['update_review'])) {
    $rating = $_POST['rating'];
    $review_text = trim($_POST['review_text']);

    updateReview($conn, $review_id, $member_id, $rating, $review_text);

    header("Location: book_details.php?id=" . $review['book_id']);
    exit();
}

if (isset($_POST['delete_review'])) {
    $book_id = $review['book_id'];

    deleteReview($conn, $review_id, $member_id);

    header("Location: book_details.php?id=" . $book_id);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<div class="topbar">

    <div class="topbar-left">
        <a href="dashboard.php" class="top-btn dashboard-btn">
            Dashboard
        </a>
    </div>

    <div class="topbar-right">
        <a href="logout.php" class="top-btn logout-top-btn">
            Logout
        </a>
    </div>

</div>



    <title>Edit Review</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>Edit Review</h2>

<a href="book_details.php?id=<?php echo $review['book_id']; ?>">Back to Book Details</a>

<br><br>

<form method="POST">
    <label>Rating</label><br>
    <select name="rating" required>
        <?php for($i = 1; $i <= 5; $i++) { ?>
            <option value="<?php echo $i; ?>" 
                <?php if($review['rating'] == $i) echo "selected"; ?>>
                <?php echo $i; ?> Star
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Review Text</label><br>
    <textarea name="review_text" rows="5" cols="50" required><?php echo $review['review_text']; ?></textarea>

    <br><br>

    <button type="submit" name="update_review">Update Review</button>

    <button type="submit" name="delete_review"
            onclick="return confirm('Are you sure you want to delete this review?');">
        Delete Review
    </button>
</form>

</body>
</html>

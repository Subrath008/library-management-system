<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$book_id = $_GET['id'] ?? 0;

handleBorrowRequest();
handleAddReadingList();
handleReviewSubmit();
handleReservationRequest();


$book = getBookDetails($conn, $book_id);
$availability = getBookAvailability($conn, $book_id);
$reviews = getBookReviews($conn, $book_id);
$avg_rating = getAverageRating($conn, $book_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    
    <link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<a href="browse_books.php">Back to Browse Books</a>

<h2><?php echo $book['title']; ?></h2>
<p>
    <strong>Average Rating:</strong>
    <?php 
    if ($avg_rating['avg_rating'] != NULL) {
        echo number_format($avg_rating['avg_rating'], 1) . " / 5";
    } else {
        echo "No rating yet";
    }
    ?>
</p>

<p><strong>Author:</strong> <?php echo $book['author']; ?></p>
<p><strong>ISBN:</strong> <?php echo $book['isbn']; ?></p>
<p><strong>Genre:</strong> <?php echo $book['genre_name']; ?></p>
<p><strong>Publisher:</strong> <?php echo $book['publisher']; ?></p>
<p><strong>Published Year:</strong> <?php echo $book['published_year']; ?></p>
<p><strong>Description:</strong> <?php echo $book['description']; ?></p>

<hr>

<h3>Branch Availability</h3>

<?php while($row = mysqli_fetch_assoc($availability)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <p><strong>Branch:</strong> <?php echo $row['branch_name']; ?></p>
        <p><strong>City:</strong> <?php echo $row['city']; ?></p>
        <p><strong>Total Copies:</strong> <?php echo $row['total_copies']; ?></p>
        <p><strong>Available Copies:</strong> <?php echo $row['available_copies']; ?></p>

        <?php if ($row['available_copies'] > 0) { ?>
            <form method="POST">
                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                <input type="hidden" name="branch_id" value="<?php echo $row['branch_id']; ?>">
                <button type="submit" name="borrow_request">Request Borrow</button>
            </form>
       <?php } else { ?>
    <p style="color:red;">No copies available</p>

    <form method="POST">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <input type="hidden" name="branch_id" value="<?php echo $row['branch_id']; ?>">
        <button type="submit" name="reserve_book">Join Reservation Waitlist</button>
    </form>
<?php } ?>

    </div>
<?php } ?>

<hr>

<form method="POST">
    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    <button type="submit" name="add_reading_list">Add to Reading List</button>
</form>

<hr>

<h3>Write Review</h3>

<form method="POST">
    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">

    <label>Rating</label><br>
    <select name="rating" required>
        <option value="">Select rating</option>
        <option value="1">1 Star</option>
        <option value="2">2 Stars</option>
        <option value="3">3 Stars</option>
        <option value="4">4 Stars</option>
        <option value="5">5 Stars</option>
    </select><br><br>

    <textarea name="review_text" rows="4" cols="50" placeholder="Write your review" required></textarea><br><br>

    <button type="submit" name="submit_review">Submit Review</button>
</form>

<hr>

<h3>Member Reviews</h3>

<?php while($review = mysqli_fetch_assoc($reviews)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <p>
            <strong><?php echo $review['name']; ?></strong>
        </p>

        <p>
            Rating: <?php echo $review['rating']; ?>/5
        </p>

        <p>
            <?php echo $review['review_text']; ?>
        </p>

        <small>
            <?php echo $review['created_at']; ?>
        </small>

        <?php if ($review['member_id'] == $_SESSION['member_id']) { ?>

            <br><br>

            <a href="edit_review.php?id=<?php echo $review['id']; ?>">
                Edit/Delete Review
            </a>

        <?php } ?>

    </div>
<?php } ?>

</body>
</html>

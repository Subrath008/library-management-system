<?php

function registerMember($conn, $name, $email, $phone, $password, $branch_id) {
    $role = "member";
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users 
            (name, email, phone, password_hash, role, branch_id, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $phone, $password_hash, $role, $branch_id);

    return mysqli_stmt_execute($stmt);
}

function getMemberByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ? AND role = 'member' LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getAllBranches($conn) {
    $sql = "SELECT * FROM branches WHERE is_active = 1 ORDER BY name ASC";
    return mysqli_query($conn, $sql);
}

function getMemberById($conn, $member_id) {
    $sql = "SELECT users.*, branches.name AS branch_name 
            FROM users 
            LEFT JOIN branches ON users.branch_id = branches.id
            WHERE users.id = ? AND users.role = 'member'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function searchBooks($conn, $keyword = "", $genre_id = "", $branch_id = "", $year = "") {
    $sql = "SELECT 
                books.*, 
                genres.name AS genre_name,
                COALESCE(SUM(branch_inventory.available_copies), 0) AS total_available
            FROM books
            LEFT JOIN genres ON books.genre_id = genres.id
            LEFT JOIN branch_inventory ON books.id = branch_inventory.book_id
            WHERE 1";

    $params = [];
    $types = "";

    if (!empty($keyword)) {
        $sql .= " AND (books.title LIKE ? OR books.author LIKE ? OR books.isbn LIKE ?)";
        $search = "%$keyword%";
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $types .= "sss";
    }

    if (!empty($genre_id)) {
        $sql .= " AND books.genre_id = ?";
        $params[] = $genre_id;
        $types .= "i";
    }

    if (!empty($branch_id)) {
        $sql .= " AND branch_inventory.branch_id = ?";
        $params[] = $branch_id;
        $types .= "i";
    }

    if (!empty($year)) {
        $sql .= " AND books.published_year = ?";
        $params[] = $year;
        $types .= "i";
    }

    $sql .= " GROUP BY books.id ORDER BY books.title ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAllGenres($conn) {
    $sql = "SELECT * FROM genres ORDER BY name ASC";
    return mysqli_query($conn, $sql);
}

function getBookDetails($conn, $book_id) {
    $sql = "SELECT books.*, genres.name AS genre_name
            FROM books
            LEFT JOIN genres ON books.genre_id = genres.id
            WHERE books.id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getBookAvailability($conn, $book_id) {
    $sql = "SELECT 
                branches.id AS branch_id,
                branches.name AS branch_name,
                branches.city,
                branch_inventory.total_copies,
                branch_inventory.available_copies
            FROM branch_inventory
            JOIN branches ON branch_inventory.branch_id = branches.id
            WHERE branch_inventory.book_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function submitBorrowRequest($conn, $member_id, $book_id, $branch_id) {
    $status = "pending";

    $sql = "INSERT INTO borrow_records 
            (member_id, book_id, branch_id, status) 
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiis", $member_id, $book_id, $branch_id, $status);

    return mysqli_stmt_execute($stmt);
}

function getActiveLoans($conn, $member_id) {
    $sql = "SELECT borrow_records.*, books.title, branches.name AS branch_name
            FROM borrow_records
            JOIN books ON borrow_records.book_id = books.id
            JOIN branches ON borrow_records.branch_id = branches.id
            WHERE borrow_records.member_id = ?
            AND borrow_records.status = 'active'
            ORDER BY borrow_records.due_date ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getBorrowHistory($conn, $member_id) {
    $sql = "SELECT borrow_records.*, books.title, branches.name AS branch_name
            FROM borrow_records
            JOIN books ON borrow_records.book_id = books.id
            JOIN branches ON borrow_records.branch_id = branches.id
            WHERE borrow_records.member_id = ?
            ORDER BY borrow_records.id DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function addToReadingList($conn, $member_id, $book_id) {

    $check_sql = "SELECT id FROM reading_lists 
                  WHERE member_id = ? AND book_id = ?";

    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $member_id, $book_id);
    mysqli_stmt_execute($check_stmt);

    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        return false;
    }

    $sql = "INSERT INTO reading_lists (member_id, book_id) 
            VALUES (?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $member_id, $book_id);

    return mysqli_stmt_execute($stmt);
}

function getReadingList($conn, $member_id) {
    $sql = "SELECT reading_lists.*, books.title, books.author
            FROM reading_lists
            JOIN books ON reading_lists.book_id = books.id
            WHERE reading_lists.member_id = ?
            ORDER BY reading_lists.added_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function removeFromReadingList($conn, $member_id, $book_id) {
    $sql = "DELETE FROM reading_lists WHERE member_id = ? AND book_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $member_id, $book_id);

    return mysqli_stmt_execute($stmt);
}

function getMemberFines($conn, $member_id) {
    $sql = "SELECT fines.*, books.title
            FROM fines
            JOIN borrow_records ON fines.borrow_record_id = borrow_records.id
            JOIN books ON borrow_records.book_id = books.id
            WHERE fines.member_id = ?
            ORDER BY fines.id DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function submitReview($conn, $book_id, $member_id, $rating, $review_text) {
    $sql = "INSERT INTO book_reviews 
            (book_id, member_id, rating, review_text) 
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiis", $book_id, $member_id, $rating, $review_text);

    return mysqli_stmt_execute($stmt);
}

function getBookReviews($conn, $book_id) {
    $sql = "SELECT book_reviews.*, users.name
            FROM book_reviews
            JOIN users ON book_reviews.member_id = users.id
            WHERE book_reviews.book_id = ?
            ORDER BY book_reviews.created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getAnnouncementsForMember($conn, $branch_id) {
    $sql = "SELECT * FROM announcements
            WHERE branch_id IS NULL OR branch_id = ?
            ORDER BY published_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $branch_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function reserveBook($conn, $member_id, $book_id, $branch_id) {

    $check_sql = "SELECT id FROM reservations
                  WHERE member_id = ?
                  AND book_id = ?
                  AND branch_id = ?
                  AND status = 'waiting'";

    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "iii", $member_id, $book_id, $branch_id);
    mysqli_stmt_execute($check_stmt);

    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        return false;
    }

    $sql = "INSERT INTO reservations 
            (member_id, book_id, branch_id, status)
            VALUES (?, ?, ?, 'waiting')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $member_id, $book_id, $branch_id);

    return mysqli_stmt_execute($stmt);
}


function updateMemberProfile($conn, $member_id, $name, $phone) {
    $sql = "UPDATE users SET name = ?, phone = ? WHERE id = ? AND role = 'member'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $phone, $member_id);

    return mysqli_stmt_execute($stmt);
}

function updateMemberPassword($conn, $member_id, $new_password) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password_hash = ? WHERE id = ? AND role = 'member'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $password_hash, $member_id);

    return mysqli_stmt_execute($stmt);
}

function updateMemberProfilePicture($conn, $member_id, $profile_pic) {
    $sql = "UPDATE users SET profile_pic = ? WHERE id = ? AND role = 'member'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $profile_pic, $member_id);

    return mysqli_stmt_execute($stmt);
}
function getReviewById($conn, $review_id, $member_id) {
    $sql = "SELECT * FROM book_reviews 
            WHERE id = ? AND member_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $review_id, $member_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateReview($conn, $review_id, $member_id, $rating, $review_text) {
    $sql = "UPDATE book_reviews 
            SET rating = ?, review_text = ?
            WHERE id = ? AND member_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isii", $rating, $review_text, $review_id, $member_id);

    return mysqli_stmt_execute($stmt);
}

function deleteReview($conn, $review_id, $member_id) {
    $sql = "DELETE FROM book_reviews 
            WHERE id = ? AND member_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $review_id, $member_id);

    return mysqli_stmt_execute($stmt);
}
function getAverageRating($conn, $book_id) {

    $sql = "SELECT AVG(rating) AS avg_rating
            FROM book_reviews
            WHERE book_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $book_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}
function getReservationPosition($conn, $reservation_id, $book_id, $branch_id) {

    $sql = "SELECT COUNT(*) + 1 AS position
            FROM reservations
            WHERE book_id = ?
            AND branch_id = ?
            AND status = 'waiting'
            AND id < ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iii",
        $book_id,
        $branch_id,
        $reservation_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}
function getMemberNotifications($conn, $member_id) {
    $sql = "SELECT * FROM notifications
            WHERE member_id = ?
            ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function markNotificationsAsRead($conn, $member_id) {
    $sql = "UPDATE notifications 
            SET is_read = 1 
            WHERE member_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);

    return mysqli_stmt_execute($stmt);
}
function getMemberReservations($conn, $member_id) {
    $sql = "SELECT reservations.*, books.title, books.author, branches.name AS branch_name
            FROM reservations
            JOIN books ON reservations.book_id = books.id
            JOIN branches ON reservations.branch_id = branches.id
            WHERE reservations.member_id = ?
            ORDER BY reservations.reserved_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function renewLoan($conn, $borrow_record_id) {

    $sql = "UPDATE borrow_records
            SET renewals_count = renewals_count + 1,
                due_date = DATE_ADD(due_date, INTERVAL 7 DAY)
            WHERE id = ?
            AND renewals_count < 2";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $borrow_record_id);

    return mysqli_stmt_execute($stmt);
}

function payFine($conn, $fine_id) {

    $sql = "UPDATE fines
            SET is_paid = 1,
                paid_at = NOW()
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $fine_id);

    return mysqli_stmt_execute($stmt);
}


function submitAnnouncementResponse($conn, $announcement_id, $member_id, $response_text) {
    $sql = "INSERT INTO announcement_responses 
            (announcement_id, member_id, response_text)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $announcement_id, $member_id, $response_text);

    return mysqli_stmt_execute($stmt);
}
function getFulfilledReservations($conn, $member_id) {
    $sql = "SELECT reservations.*, books.title, branches.name AS branch_name
            FROM reservations
            JOIN books ON reservations.book_id = books.id
            JOIN branches ON reservations.branch_id = branches.id
            WHERE reservations.member_id = ?
            AND reservations.status = 'fulfilled'
            ORDER BY reservations.reserved_at DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}



?>

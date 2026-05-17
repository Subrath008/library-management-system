<?php
include_once(__DIR__ . "/../config/db.php");
include_once(__DIR__ . "/../models/MemberModel.php");

function requireMemberLogin() {
    if (!isset($_SESSION['member_id'])) {
        header("Location: login.php");
        exit();
    }
}

function handleMemberRegister() {
    global $conn;

    $message = "";

    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $branch_id = $_POST['branch_id'];

        if ($name == "" || $email == "" || $phone == "" || $password == "" || $branch_id == "") {
            $message = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email address.";
        } elseif (getMemberByEmail($conn, $email)) {
            $message = "Email already registered.";
        } else {
            if (registerMember($conn, $name, $email, $phone, $password, $branch_id)) {
                $message = "Registration successful. Please login.";
            } else {
                $message = "Registration failed.";
            }
        }
    }

    return $message;
}

function handleMemberLogin() {
    global $conn;

    $message = "";

    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $member = getMemberByEmail($conn, $email);

        if ($member && password_verify($password, $member['password_hash'])) {
            if ($member['is_active'] == 1) {
                $_SESSION['member_id'] = $member['id'];
                $_SESSION['member_name'] = $member['name'];
                $_SESSION['member_branch_id'] = $member['branch_id'];

                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Your account is inactive.";
            }
        } else {
            $message = "Invalid email or password.";
        }
    }

    return $message;
}

function logoutMember() {
    session_destroy();
    header("Location: login.php");
    exit();
}

function handleBorrowRequest() {
    global $conn;

    if (isset($_POST['borrow_request'])) {
        $member_id = $_SESSION['member_id'];
        $book_id = $_POST['book_id'];
        $branch_id = $_POST['branch_id'];

        submitBorrowRequest($conn, $member_id, $book_id, $branch_id);

        header("Location: active_loans.php");
        exit();
    }
}

function handleAddReadingList() {
    global $conn;

    if (isset($_POST['add_reading_list'])) {
        $member_id = $_SESSION['member_id'];
        $book_id = $_POST['book_id'];

        addToReadingList($conn, $member_id, $book_id);

        header("Location: reading_list.php");
        exit();
    }
}

function handleRemoveReadingList() {
    global $conn;

    if (isset($_GET['remove_book'])) {
        $member_id = $_SESSION['member_id'];
        $book_id = $_GET['remove_book'];

        removeFromReadingList($conn, $member_id, $book_id);

        header("Location: reading_list.php");
        exit();
    }
}

function handleReviewSubmit() {
    global $conn;

    if (isset($_POST['submit_review'])) {
        $member_id = $_SESSION['member_id'];
        $book_id = $_POST['book_id'];
        $rating = $_POST['rating'];
        $review_text = trim($_POST['review_text']);

        if ($rating >= 1 && $rating <= 5 && $review_text != "") {
            submitReview($conn, $book_id, $member_id, $rating, $review_text);
        }

        header("Location: book_details.php?id=" . $book_id);
        exit();
    }
}

function handleReservationRequest() {
    global $conn;

    if (isset($_POST['reserve_book'])) {
        $member_id = $_SESSION['member_id'];
        $book_id = $_POST['book_id'];
        $branch_id = $_POST['branch_id'];

        reserveBook($conn, $member_id, $book_id, $branch_id);

        header("Location: reservations.php");
        exit();
    }
}
function handleProfileUpdate() {
    global $conn;

    $message = "";

    if (isset($_POST['update_profile'])) {

        $member_id = $_SESSION['member_id'];

        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);

        if ($name == "" || $phone == "") {
            $message = "Name and phone are required.";
        } else {

            updateMemberProfile($conn, $member_id, $name, $phone);

            $_SESSION['member_name'] = $name;

            $message = "Profile updated successfully.";
        }
    }

    return $message;
}

function handlePasswordChange() {
    global $conn;

    $message = "";

    if (isset($_POST['change_password'])) {

        $member_id = $_SESSION['member_id'];

        $new_password = $_POST['new_password'];

        if (strlen($new_password) < 6) {

            $message = "Password must be at least 6 characters.";

        } else {

            updateMemberPassword($conn, $member_id, $new_password);

            $message = "Password updated successfully.";
        }
    }

    return $message;
}

function handleProfilePictureUpload() {
    global $conn;

    $message = "";

    if (isset($_POST['upload_picture'])) {

        $member_id = $_SESSION['member_id'];

        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

            $folder = "../../uploads/profile_pictures/";

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $filename = time() . "_" . basename($_FILES['profile_pic']['name']);

            $target = $folder . $filename;

            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {

                $db_path = "uploads/profile_pictures/" . $filename;

                updateMemberProfilePicture($conn, $member_id, $db_path);

                $message = "Profile picture uploaded successfully.";

            } else {

                $message = "Upload failed.";
            }

        } else {

            $message = "Please select an image.";
        }
    }

    return $message;
}

?>


<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
?>

<h1>Welcome Librarian</h1>

<p>Name: <?php echo $_SESSION['librarian']; ?></p>
<p>Branch ID: <?php echo $_SESSION['branch_id']; ?></p>

<ul>
    <li><a href="add_book.php">Add Book</a></li>
    <li><a href="view_books.php">View Books</a></li>
    <li><a href="manage_genres.php">Manage Genres</a></li>
    <li><a href="manage_inventory.php">Manage Inventory</a></li>
    <li><a href="borrow_requests.php">Borrow Requests</a></li>
    <li><a href="active_loans.php">Active Loans</a></li>
    <li><a href="process_return.php">Process Returns</a></li>
    <li><a href="manage_fines.php">Manage Fines</a></li>
    <li><a href="announcements.php">Announcements</a></li>
    <li><a href="ajax_book_search.php">AJAX Book Search</a></li>
    <li><a href="manual_fine.php">Manual Fine</a></li>
    <li><a href="search_members.php">Search Members</a></li>
    <li><a href="catalog_statistics.php">Catalog Statistics</a></li>
    <li><a href="reservations.php">Reservations</a></li>
</ul>

<a href="../../controllers/AuthController.php?logout=1">Logout</a>
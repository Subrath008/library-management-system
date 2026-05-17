<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">

<div style="
max-width:1100px;
margin:auto;
padding:20px;
">

    <div style="
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:25px;
    ">

        <h1 style="
        margin-top:0;
        color:#0b5ed7;
        font-size:42px;
        ">
            Librarian Dashboard
        </h1>

        <p style="font-size:20px;">
            <b>Name:</b>
            <?php echo $_SESSION['librarian']; ?>
        </p>

        <p style="font-size:20px;">
            <b>Branch ID:</b>
            <?php echo $_SESSION['branch_id']; ?>
        </p>

    </div>

    <div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    ">

        <a href="add_book.php" class="dash-card">Add Book</a>

        <a href="view_books.php" class="dash-card">View Books</a>

        <a href="manage_genres.php" class="dash-card">Manage Genres</a>

        <a href="manage_inventory.php" class="dash-card">Manage Inventory</a>

        <a href="borrow_requests.php" class="dash-card">Borrow Requests</a>

        <a href="active_loans.php" class="dash-card">Active Loans</a>

        <a href="process_return.php" class="dash-card">Process Returns</a>

        <a href="manage_fines.php" class="dash-card">Manage Fines</a>

        <a href="manual_fine.php" class="dash-card">Manual Fine</a>

        <a href="announcements.php" class="dash-card">Announcements</a>

        <a href="ajax_book_search.php" class="dash-card"> Book Search</a>

        <a href="search_members.php" class="dash-card">Search Members</a>

        <a href="catalog_statistics.php" class="dash-card">Catalog Statistics</a>

        <a href="reservations.php" class="dash-card">Reservations</a>

    </div>

    <div style="margin-top:30px;">

        <a href="../../controllers/AuthController.php?logout=1"
           style="
           background:#dc3545;
           color:white;
           padding:12px 20px;
           border-radius:6px;
           text-decoration:none;
           font-weight:bold;
           ">
           Logout
        </a>

    </div>

</div>
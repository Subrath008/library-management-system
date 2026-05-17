<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once("../../controllers/MemberController.php");

requireMemberLogin();

$genres = getAllGenres($conn);
$branches = getAllBranches($conn);
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

    <title>Browse Books</title>
    
<link rel="stylesheet" href="../../assets/css/member.css">

</head>
<body>

<h2>Browse Books</h2>


<br><br>

<input type="text" id="keyword" placeholder="Search title, author, ISBN">

<select id="genre_id">
    <option value="">All Genres</option>
    <?php while($genre = mysqli_fetch_assoc($genres)) { ?>
        <option value="<?php echo $genre['id']; ?>">
            <?php echo $genre['name']; ?>
        </option>
    <?php } ?>
</select>

<select id="branch_id">
    <option value="">All Branches</option>
    <?php while($branch = mysqli_fetch_assoc($branches)) { ?>
        <option value="<?php echo $branch['id']; ?>">
            <?php echo $branch['name']; ?>
        </option>
    <?php } ?>
</select>

<input type="number" id="year" placeholder="Year">

<button type="button" onclick="searchBooks()">Search</button>

<hr>

<div id="bookResults">Loading books...</div>

<script>
function searchBooks() {
    var keyword = document.getElementById("keyword").value;
    var genre_id = document.getElementById("genre_id").value;
    var branch_id = document.getElementById("branch_id").value;
    var year = document.getElementById("year").value;

    var url = "../../api/member_search_books.php?keyword=" + encodeURIComponent(keyword)
        + "&genre_id=" + encodeURIComponent(genre_id)
        + "&branch_id=" + encodeURIComponent(branch_id)
        + "&year=" + encodeURIComponent(year);

    var xhr = new XMLHttpRequest();

    xhr.open("GET", url, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var books = JSON.parse(xhr.responseText);
            var output = "";

            if (books.length === 0) {
                output = "<p>No books found.</p>";
            } else {
                books.forEach(function(book) {
                    output += "<div style='border:1px solid #ccc; padding:15px; margin-bottom:10px;'>";
                    output += "<h3>" + book.title + "</h3>";
                    output += "<p><strong>Author:</strong> " + book.author + "</p>";
                    output += "<p><strong>ISBN:</strong> " + book.isbn + "</p>";
                    output += "<p><strong>Genre:</strong> " + book.genre_name + "</p>";
                    output += "<p><strong>Published Year:</strong> " + book.published_year + "</p>";
                    output += "<p><strong>Total Available Copies:</strong> " + book.total_available + "</p>";
                    output += "<a href='book_details.php?id=" + book.id + "'>View Details</a>";
                    output += "</div>";
                });
            }

            document.getElementById("bookResults").innerHTML = output;
        }
    };

    xhr.send();
}

searchBooks();
</script>

</body>
</html>





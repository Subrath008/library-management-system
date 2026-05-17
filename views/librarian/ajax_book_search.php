<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="../../assets/css/librarian.css">
<div style="margin-bottom:20px;">
    <a href="dashboard.php"
       style="
       background:#0b5ed7;
       color:white;
       padding:10px 15px;
       border-radius:5px;
       text-decoration:none;">
       ← Back to Dashboard
    </a>
</div>

<h2>AJAX Live Book Search</h2>

<input type="text" id="searchInput" placeholder="Search by title, author, or ISBN">

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Publisher</th>
            <th>Year</th>
        </tr>
    </thead>
    <tbody id="bookResults"></tbody>
</table>

<br>


<script>
function loadBooks(searchValue = "") {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../../api/search_books.php?search=" + encodeURIComponent(searchValue), true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var books = JSON.parse(xhr.responseText);
            var output = "";

            books.forEach(function(book) {
                output += "<tr>";
                output += "<td>" + book.id + "</td>";
                output += "<td>" + book.title + "</td>";
                output += "<td>" + book.author + "</td>";
                output += "<td>" + book.isbn + "</td>";
                output += "<td>" + book.publisher + "</td>";
                output += "<td>" + book.published_year + "</td>";
                output += "</tr>";
            });

            document.getElementById("bookResults").innerHTML = output;
        }
    };

    xhr.send();
}

document.getElementById("searchInput").addEventListener("keyup", function() {
    loadBooks(this.value);
});

loadBooks();
</script>
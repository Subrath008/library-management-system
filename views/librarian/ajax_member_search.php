<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">
<?php include "navbar.php"; ?>

<h2> Member Search</h2>

<input type="text" id="memberSearch" placeholder="Search by name, email, or phone">

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Branch ID</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="memberResults"></tbody>
</table>

<script>
function loadMembers(keyword = "") {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../../api/search_members.php?keyword=" + encodeURIComponent(keyword), true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var members = JSON.parse(xhr.responseText);
            var output = "";

            members.forEach(function(member) {
                output += "<tr>";
                output += "<td>" + member.id + "</td>";
                output += "<td>" + member.name + "</td>";
                output += "<td>" + member.email + "</td>";
                output += "<td>" + member.phone + "</td>";
                output += "<td>" + member.branch_id + "</td>";
                output += "<td><a href='member_history.php?id=" + member.id + "'>View History</a></td>";
                output += "</tr>";
            });

            document.getElementById("memberResults").innerHTML = output;
        }
    };

    xhr.send();
}

document.getElementById("memberSearch").addEventListener("keyup", function() {
    loadMembers(this.value);
});

loadMembers();
</script>
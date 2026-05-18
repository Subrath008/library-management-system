<?php
session_start();

if(!isset($_SESSION['librarian'])){
    header("Location: login.php");
    exit();
}

include "../../controllers/ReservationController.php";
?>

<link rel="stylesheet" href="../../assets/css/librarian.css">

<?php include "navbar.php"; ?>

<h2>Reservation Waitlist</h2>

<p><?php echo $message; ?></p>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Member ID</th>
        <th>Book</th>
        <th>Branch ID</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td><?php echo $row['member_id']; ?></td>

            <td><?php echo $row['title']; ?></td>

            <td><?php echo $row['branch_id']; ?></td>

            <td><?php echo $row['status']; ?></td>

            <td>

                <?php if($row['status'] == 'waiting'){ ?>

                    <a href="reservations.php?fulfill=<?php echo $row['id']; ?>">
                        Fulfill
                    </a>

                <?php } else { ?>

                    Fulfilled

                <?php } ?>

            </td>

        </tr>

    <?php } ?>

</table>
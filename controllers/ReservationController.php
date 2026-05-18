<?php

include __DIR__ . "/../config/db.php";
include __DIR__ . "/../models/Reservation.php";

$reservationModel = new Reservation($conn);

$message = "";

if(isset($_GET['fulfill'])){

    $id = $_GET['fulfill'];

    if($reservationModel->fulfillReservation($id)){
        $message = "Reservation fulfilled successfully";
    }
    else{
        $message = "Failed to update reservation";
    }
}

$result = $reservationModel->getReservations();

?>
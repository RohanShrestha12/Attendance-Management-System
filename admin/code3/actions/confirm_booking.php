<?php
include '../../database/db.php';

$booking_id = $_POST['id'];
$conn->query("UPDATE bookings SET status='Confirmed' WHERE booking_id=$booking_id");
$conn->close();
?>

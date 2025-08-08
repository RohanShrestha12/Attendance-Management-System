<?php
include '../database/db.php';

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Update the booking status to "Cancelled"
    $cancel_query = "UPDATE bookings SET status = 'canceled' WHERE booking_id = $booking_id";
    if ($conn->query($cancel_query) === TRUE) {
        echo "Booking cancelled successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

header("Location: manage_bookings.php"); // Redirect back to manage bookings page
?>

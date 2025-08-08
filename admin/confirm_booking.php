<?php
include '../database/db.php';

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Update the booking status to "Confirmed"
    $confirm_query = "UPDATE bookings SET status = 'Confirmed' WHERE booking_id = $booking_id";
    if ($conn->query($confirm_query) === TRUE) {
        echo "Booking confirmed successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

header("Location: manage_bookings.php"); // Redirect back to manage bookings page
?>

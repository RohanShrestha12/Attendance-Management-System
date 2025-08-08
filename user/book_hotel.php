<?php
include '../database/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelId = $_POST['hotel_id'];
    $userId = $_POST['user_id'];
    $numGuests = $_POST['num_guests'];
    $checkInDate = $_POST['check_in_date'];
    $checkOutDate = $_POST['check_out_date'];
    $totalAmount = $_POST['total_amount'];

    // Insert booking into the bookings table
    $sql = "INSERT INTO bookings (user_id, hotel_id, num_guests, check_in_date, check_out_date, total_amount, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisss", $userId, $hotelId, $numGuests, $checkInDate, $checkOutDate, $totalAmount);

    if ($stmt->execute()) {
        // Redirect to a confirmation page or display a success message
        header("Location: confirmation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

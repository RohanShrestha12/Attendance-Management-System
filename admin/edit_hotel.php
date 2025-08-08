<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $hotel_name = $_POST['hotel_name'];
    $location_id = $_POST['location_id'];
    $price_per_night = $_POST['price_per_night'];
    $amenities = $_POST['amenities'];
    $rating = $_POST['rating'];

    // Update hotel in the database
    $update_query = "UPDATE hotels SET hotel_name=?, location_id=?, price_per_night=?, amenities=?, rating=? WHERE hotel_id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("siissi", $hotel_name, $location_id, $price_per_night, $amenities, $rating, $hotel_id);

    if ($stmt->execute()) {
        header("Location: manage_hotels.php?success=Hotel updated successfully");
    } else {
        header("Location: manage_hotels.php?error=Error updating hotel");
    }
    $stmt->close();
}
?>

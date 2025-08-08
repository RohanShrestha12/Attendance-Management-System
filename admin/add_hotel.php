<?php

include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_name = $_POST['hotel_name'];
    $location_id = $_POST['location_id'];
    $amenities = $_POST['amenities'];
    $price_per_night = $_POST['price_per_night'];
    $rating = $_POST['rating'];

    $query = "INSERT INTO hotels (hotel_name, location_id, amenities, price_per_night, rating) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sisdi', $hotel_name, $location_id, $amenities, $price_per_night, $rating);

    if ($stmt->execute()) {
        header("Location: manage_hotels.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


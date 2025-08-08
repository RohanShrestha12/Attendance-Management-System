<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_name = $_POST['hotel_name'];
    $location_id = $_POST['location_id'];
    $amenities = $_POST['amenities'];
    $price_per_night = $_POST['price_per_night'];
    $rating = $_POST['rating'];

    $query = "INSERT INTO hotels (hotel_name, location_id, amenities, price_per_night, rating) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sisdi', $hotel_name, $location_id, $amenities, $price_per_night, $rating);

    if ($stmt->execute()) {
        header("Location: manage_hotels.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hotel</title>
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Add New Hotel</h3>
        <form method="post">
            <div class="mb-3">
                <label for="hotel_name" class="form-label">Hotel Name</label>
                <input type="text" class="form-control" id="hotel_name" name="hotel_name" required>
            </div>
            <div class="mb-3">
                <label for="location_id" class="form-label">Location ID</label>
                <input type="number" class="form-control" id="location_id" name="location_id" required>
            </div>
            <div class="mb-3">
                <label for="amenities" class="form-label">Amenities</label>
                <textarea class="form-control" id="amenities" name="amenities" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price_per_night" class="form-label">Price per Night</label>
                <input type="number" class="form-control" id="price_per_night" name="price_per_night" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" step="0.1" class="form-control" id="rating" name="rating" required>
            </div>
            <button type="submit" class="btn btn-success">Add Hotel</button>
        </form>
    </div>
</body>
</html>

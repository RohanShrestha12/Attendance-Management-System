<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $hotel_id = $_GET['id'];
    // Fetch hotel data for the given $hotel_id

    // Handle form submissions for editing hotel
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Your logic to update the hotel data in the database
        header("Location: manage_hotels.php");
        exit();
    }
}

// Fetch hotel data for the form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hotel</title>
</head>
<body>
<form method="POST" action="">
    <input type="text" name="hotel_name" placeholder="Hotel Name" value="<?= $hotel_name ?>" required>
    <input type="text" name="location_id" placeholder="Location ID" value="<?= $location_id ?>" required>
    <input type="number" name="price_per_night" placeholder="Price Per Night" value="<?= $price_per_night ?>" required>
    <input type="number" name="rating" placeholder="Rating" value="<?= $rating ?>" required>
    <button type="submit">Update Hotel</button>
</form>
</body>
</html>

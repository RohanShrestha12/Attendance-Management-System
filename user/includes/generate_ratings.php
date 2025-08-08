<?php
include '../../database/db.php'; // Database connection

// Existing users and hotels
$users = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 19, 21, 22];
$hotels = [1, 2, 3, 4, 5, 11, 12, 13, 15, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80];

// Check existing ratings count
$currentRatings = $conn->query("SELECT COUNT(*) AS count FROM ratings")->fetch_assoc()['count'];

// Target at least 100 ratings
$targetRatings = 100;
$ratingsToAdd = $targetRatings - $currentRatings;

if ($ratingsToAdd > 0) {
    // Generate random ratings
    $ratingsAdded = 0;
    while ($ratingsAdded < $ratingsToAdd) {
        $userId = $users[array_rand($users)];
        $hotelId = $hotels[array_rand($hotels)];
        $rating = round(rand(10, 50) / 10, 1); // Random rating between 1.0 and 5.0

        // Check if this user-hotel pair already exists
        $check = $conn->prepare("SELECT * FROM ratings WHERE user_id = ? AND hotel_id = ?");
        $check->bind_param("ii", $userId, $hotelId);
        $check->execute();
        $existingRating = $check->get_result();

        if ($existingRating->num_rows === 0) {
            // Insert new rating
            $stmt = $conn->prepare("INSERT INTO ratings (user_id, hotel_id, rating) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $userId, $hotelId, $rating);
            $stmt->execute();
            $stmt->close();
            $ratingsAdded++;
        }
    }

    echo "Added $ratingsToAdd new ratings to the database.";
} else {
    echo "You already have $currentRatings ratings, which is sufficient.";
}

$conn->close();
?>

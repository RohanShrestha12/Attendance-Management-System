<?php
include '../../database/db.php';  // Include the database connection file

// Function to fetch all hotels
function getHotels($conn) {
    $query = "SELECT hotel_id, hotel_name FROM hotels";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to fetch all ratings
function getAllRatings($conn) {
    $query = "SELECT rating_id, user_id, hotel_id, rating FROM ratings";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to fetch ratings for a specific hotel
function getRatingsForHotel($conn, $hotelId) {
    $query = "SELECT user_id, rating FROM ratings WHERE hotel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotelId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to fetch ratings between two users (for similarity calculation)
function getRatingsBetweenUsers($conn, $userId1, $userId2) {
    $query = "
        SELECT r1.hotel_id, r1.rating AS x_rating, r2.rating AS y_rating
        FROM ratings r1
        JOIN ratings r2 ON r1.hotel_id = r2.hotel_id
        WHERE r1.user_id = ? AND r2.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId1, $userId2);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to fetch all users for similarity calculation
function getAllUsers($conn, $excludeUserId) {
    $query = "SELECT DISTINCT user_id FROM ratings WHERE user_id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $excludeUserId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Example usage
$userId = 1;  // Example user ID
$hotelId = 1;  // Example hotel ID

$hotels = getHotels($conn);
$allRatings = getAllRatings($conn);
$ratingsForHotel = getRatingsForHotel($conn, $hotelId);
$ratingsBetweenUsers = getRatingsBetweenUsers($conn, 1, 2);  // Compare user 1 and 2
$usersForSimilarity = getAllUsers($conn, $userId);

echo "<pre>";
print_r($hotels);
print_r($allRatings);
print_r($ratingsForHotel);
print_r($ratingsBetweenUsers);
print_r($usersForSimilarity);
echo "</pre>";
?>

<?php
// Database connection
$conn = new mysqli("localhost", "username", "password", "database");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the hotel_id from the request
$hotel_id = $_GET['hotel_id'];

// Query the database for hotel details
$sql = "SELECT hotel_name, price_per_night FROM hotels WHERE hotel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();

// If hotel is found, return the details as JSON
if ($result->num_rows > 0) {
    $hotel = $result->fetch_assoc();
    echo json_encode($hotel);
} else {
    echo json_encode(["error" => "Hotel not found"]);
}

$stmt->close();
$conn->close();
?>

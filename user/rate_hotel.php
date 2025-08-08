<?php
session_start();
include '../database/db.php';

// Get the logged-in user's ID from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Read and decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is received
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

// Extract hotel_id and rating from input
$hotel_id = isset($data['hotel_id']) ? (int)$data['hotel_id'] : null;
$rating = isset($data['rating']) ? (int)$data['rating'] : null;

// Validate input
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if (!$hotel_id || !$rating || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

try {
    // Check if the user has already rated this hotel
    $checkQuery = "SELECT rating_id FROM ratings WHERE user_id = ? AND hotel_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ii', $user_id, $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing rating
        $updateQuery = "UPDATE ratings SET rating = ? WHERE user_id = ? AND hotel_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('iii', $rating, $user_id, $hotel_id);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Rating updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update rating.']);
        }

        $updateStmt->close();
    } else {
        // Insert a new rating
        $insertQuery = "INSERT INTO ratings (user_id, hotel_id, rating) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('iii', $user_id, $hotel_id, $rating);

        if ($insertStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Rating added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add rating.']);
        }

        $insertStmt->close();
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn->close();
?>

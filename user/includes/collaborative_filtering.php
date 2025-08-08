<?php
include '../../database/db.php';

// Start the session
session_start();

// Ensure user is logged in by checking session variable
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Get the user_id from session
$userId = $_SESSION['user_id'];

class CollaborativeRecommender {
    private $conn;
    private $userId;

    public function __construct($conn, $userId) {
        $this->conn = $conn;
        $this->userId = $userId;
    }

    // Retrieve similar users based on rating patterns
    private function getSimilarUsers() {
        $similarUsers = [];
        
        $query = "
        SELECT ur.user_id, ur.hotel_id, ur.rating
        FROM ratings ur
        INNER JOIN (
            SELECT hotel_id 
            FROM ratings 
            WHERE user_id = ?
        ) AS current_user_hotels 
        ON ur.hotel_id = current_user_hotels.hotel_id
        WHERE ur.user_id != ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->userId, $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $similarUsers[$row['user_id']]['rated_hotels'][$row['hotel_id']] = $row['rating'];
        }

        return $similarUsers;
    }

    // Aggregate ratings from similar users
    private function collaborativeRecommendations($similarUsers) {
        $collabScores = [];

        foreach ($similarUsers as $user) {
            foreach ($user['rated_hotels'] as $hotelId => $rating) {
                if (!isset($collabScores[$hotelId])) {
                    $collabScores[$hotelId] = 0;
                }
                $collabScores[$hotelId] += $rating;
            }
        }

        return $collabScores;
    }

    // Get top recommendations
    public function getRecommendations() {
        $similarUsers = $this->getSimilarUsers();
        $collabScores = $this->collaborativeRecommendations($similarUsers);

        // Sort by collaborative scores in descending order
        arsort($collabScores);

        // Fetch top hotel IDs
        $hotelIds = array_keys($collabScores);

        if (empty($hotelIds)) {
            return [];
        }

        // Fetch hotel details
        $placeholders = implode(",", array_fill(0, count($hotelIds), "?"));
        $query = "SELECT * FROM hotels WHERE hotel_id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(str_repeat("i", count($hotelIds)), ...$hotelIds);
        $stmt->execute();
        $result = $stmt->get_result();

        $recommendedHotels = [];
        while ($row = $result->fetch_assoc()) {
            $recommendedHotels[] = $row;
        }

        return $recommendedHotels;
    }
}

// Initialize the recommender
$recommender = new CollaborativeRecommender($conn, $userId);
$recommendedHotels = $recommender->getRecommendations();
?>

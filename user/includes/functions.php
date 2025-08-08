<?php
include_once '../database/db.php';  // Include your database connection

// Function to fetch hotels
function fetch_hotels($limit = 6) {
    global $conn;
    $sql = "SELECT * FROM hotels  order by hotel_name ASC LIMIT ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $hotels = [];
    
    $row = $result->fetch_all(MYSQLI_ASSOC);
    return $row;
}

// Function to fetch locations
function fetch_locations($limit = 6) {
    global $conn;
    $sql = "SELECT * FROM locations LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    return $locations;
}

// Function to fetch packages
function fetch_packages($limit = 6) {
    global $conn;
    $sql = "SELECT * FROM packages LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $packages = [];
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
    return $packages;
}

// Function to fetch booked hotels
function fetch_booked_hotels($conn, $user_id) {
    $sql = "SELECT 
    h.hotel_id,
    b.user_id,
    (SELECT rating FROM ratings r WHERE r.user_id = b.user_id AND r.hotel_id = h.hotel_id LIMIT 1) AS user_rating,
    h.hotel_name,
    h.image_url,
    h.amenities,
    h.price_per_night,
    h.rating
FROM bookings b
JOIN hotels h ON b.hotel_id = h.hotel_id
WHERE b.user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookedHotels = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $bookedHotels;
    } else {
        echo "Error: " . $conn->error;
        return [];
    }
}

// Search functionality
function search_all($query) {
    global $conn;
    $stmt = $conn->prepare("
        (SELECT hotel_id AS id, hotel_name AS name, amenities, image_url, 'hotel' AS type 
        FROM hotels 
        WHERE hotel_name LIKE ? OR amenities LIKE ?)
        
        UNION
        
        (SELECT location_id AS id, location_name AS name, description, image_url, 'location' AS type 
        FROM locations 
        WHERE location_name LIKE ? OR description LIKE ?)
        
        UNION
        
        (SELECT package_id AS id, package_name AS name, description, image_url, 'package' AS type 
        FROM packages 
        WHERE package_name LIKE ? OR description LIKE ?)
    ");

    $query = "%{$query}%";
    $stmt->bind_param("ssssss", $query, $query, $query, $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch search history
function fetch_search_history($conn, $user_id) {
    $stmt = $conn->prepare("SELECT search_query FROM search_history WHERE user_id = ? ORDER BY search_date DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $searchHistory = [];
    while ($row = $result->fetch_assoc()) {
        $searchHistory[] = $row['search_query'];
    }

    $stmt->close();
    return $searchHistory;
}

// Recommend based on search history
function recommend_based_on_search_history($searchHistory, $hotels) {
    $recommendedHotels = [];

    foreach ($searchHistory as $query) {
        foreach ($hotels as $hotel) {
            if (stripos($hotel['hotel_name'], $query) !== false) {
                $recommendedHotels[] = $hotel;
            }
        }
    }

    return array_unique($recommendedHotels);
}

// Fetch user preferences
function fetch_user_preferences($conn, $userId) {
    $query = "
        SELECT up.user_id, up.budget, r.hotel_id, h.amenities 
        FROM user_preferences up 
        INNER JOIN ratings r ON up.rating_id = r.rating_id
        INNER JOIN hotels h ON r.hotel_id = h.hotel_id
        WHERE up.user_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $preferences = [];
        while ($row = $result->fetch_assoc()) {
            $preferences[] = $row;
        }
        $stmt->close();
        return $preferences;
    } else {
        echo "Error: " . $conn->error;
        return [];
    }
}

// Fetch rated hotels
function fetch_rated_hotels($conn, $userId) {
    $query = "
        SELECT r.rating, h.hotel_id, h.hotel_name, h.price_per_night, h.amenities, h.rating AS hotel_rating 
        FROM ratings r 
        INNER JOIN hotels h ON r.hotel_id = h.hotel_id 
        WHERE r.user_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $ratedHotels = [];
        while ($row = $result->fetch_assoc()) {
            $ratedHotels[] = $row;
        }
        $stmt->close();
        return $ratedHotels;
    } else {
        echo "Error: " . $conn->error;
        return [];
    }
}

// Fetch all user ratings
function fetch_all_user_ratings($conn) {
    $query = "SELECT * FROM ratings";
    $result = mysqli_query($conn, $query);

    $allUserRatings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $allUserRatings[] = $row;
    }
    return $allUserRatings;
}

// Hybrid algorithm combining content-based, collaborative filtering, and decision tree
function hybrid_algorithm($userPreferences, $ratedHotels, $allUserRatings, $hotels, $conn) {
    $hotelRecommendations = [];

    // If the user is logged in and has rated hotels, use collaborative and content-based filtering
    if (!empty($userPreferences) && !empty($ratedHotels)) {
        // Collaborative filtering recommendations
        $collaborativeRecommendations = collaborative_filtering($userPreferences, $allUserRatings, $ratedHotels);

        // Content-based filtering recommendations
        $contentBasedRecommendations = content_based_filtering($userPreferences, $hotels);

        // Combine collaborative and content-based recommendations
        $hotelRecommendations = array_unique(array_merge($collaborativeRecommendations, $contentBasedRecommendations));
        
        // Fetch hotel details for the recommended hotel IDs
        $hotelRecommendations = fetch_hotels_by_ids($conn, $hotelRecommendations);
    }

    // If no recommendations based on ratings/preferences, fall back to Decision Tree logic
    if (empty($hotelRecommendations)) {
        $decisionTree = new DecisionTree($conn);
        $recommendedHotelsFromTree = $decisionTree->buildTree();

        // Fetch hotel details for decision tree recommended hotel IDs
        $hotelRecommendations = fetch_hotels_by_ids($conn, $recommendedHotelsFromTree);
    }

    // If no hotels found (edge case), return default hotels
    if (empty($hotelRecommendations)) {
        $hotelRecommendations = array_slice($hotels, 0, 4);  // Fallback: first 4 hotels as default
    }

    return $hotelRecommendations;
}

function fetch_hotels_by_ids($conn, $hotelIds) {
    if (empty($hotelIds)) return [];

    $ids = implode(",", $hotelIds);
    $sql = "SELECT * FROM hotels WHERE hotel_id IN ($ids)";
    $result = $conn->query($sql);

    $hotels = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hotels[] = $row;
        }
    }

    return $hotels;
}



// Decision Tree Algorithm
class DecisionTree {
    private $conn;
    private $data;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->data = $this->fetchDataFromDatabase();
    }

    private function fetchDataFromDatabase() {
        $sql = "
            SELECT hotels.hotel_id, hotels.hotel_name, ratings.rating, COUNT(search_history.hotel_id) AS search_count, COUNT(bookings.hotel_id) AS booking_count
            FROM hotels
            LEFT JOIN ratings ON hotels.hotel_id = ratings.hotel_id
            LEFT JOIN search_history ON hotels.hotel_id = search_history.hotel_id
            LEFT JOIN bookings ON hotels.hotel_id = bookings.hotel_id
            GROUP BY hotels.hotel_id";
        
        $result = $this->conn->query($sql);
        
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'hotel_id' => $row['hotel_id'],
                    'hotel_name' => $row['hotel_name'],
                    'rating' => $row['rating'],
                    'search_count' => $row['search_count'],
                    'booking_count' => $row['booking_count']
                ];
            }
        }
        return $data;
    }

    public function buildTree() {
        $hotels = $this->data;
        $recommendedHotels = [];

        foreach ($hotels as $hotel) {
            if ($hotel['rating'] >= 4 || $hotel['search_count'] > 5 || $hotel['booking_count'] > 3) {
                $recommendedHotels[] = $hotel['hotel_id'];
            }
        }

        return $recommendedHotels;
    }
}

// Collaborative Filtering
function collaborative_filtering($preferences, $allUserRatings, $ratedHotels) {
    $collaborativeRecommendations = [];

    foreach ($allUserRatings as $userRating) {
        foreach ($preferences as $preference) {
            if ($userRating['rating'] >= 4 && $preference['user_id'] != $userRating['user_id']) {
                foreach ($ratedHotels as $hotel) {
                    if ($hotel['hotel_id'] == $userRating['hotel_id']) {
                        $collaborativeRecommendations[] = $hotel['hotel_id'];
                    }
                }
            }
        }
    }

    return array_unique($collaborativeRecommendations);
}

// Content-Based Filtering
function content_based_filtering($preferences, $hotels) {
    $contentBasedRecommendations = [];

    foreach ($preferences as $preference) {
        foreach ($hotels as $hotel) {
            if (stripos($hotel['amenities'], $preference['amenities']) !== false && $hotel['price_per_night'] <= $preference['budget']) {
                $contentBasedRecommendations[] = $hotel['hotel_id'];
            }
        }
    }

    return array_unique($contentBasedRecommendations);
}

// Main logic
// Main logic
// Main logic
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];  // Fetch user_id from session
    
    // Fetch user-specific data
    $userPreferences = fetch_user_preferences($conn, $userId);  // Fetch user preferences
    $ratedHotels = fetch_rated_hotels($conn, $userId);  // Fetch rated hotels
} else {
    // Set default values for unlogged users
    $userPreferences = [];  // Empty array for user preferences
    $ratedHotels = [];  // Empty array for rated hotels
}

// Fetch all hotels and ratings (common for both logged and unlogged users)
$hotels = fetch_hotels();  // Fetch hotels
$allUserRatings = fetch_all_user_ratings($conn);  // Fetch all user ratings

// Call the hybrid algorithm (use empty arrays for unlogged users)
$recommendedHotels = hybrid_algorithm($userPreferences, $ratedHotels, $allUserRatings, $hotels, $conn);




<?php
include '../../database/db.php';

class CollaborativeFiltering {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Calculate similarity between two users (x and y) using Pearson correlation.
     */
    private function calculateSimilarity($x, $y) {
        $query = "
            SELECT x.hotel_id, x.rating AS x_rating, y.rating AS y_rating
            FROM ratings x
            INNER JOIN ratings y ON x.hotel_id = y.hotel_id
            WHERE x.user_id = ? AND y.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $x, $y);
        $stmt->execute();
        $result = $stmt->get_result();

        $sumX = $sumY = $sumXY = $sumX2 = $sumY2 = $n = 0;

        while ($row = $result->fetch_assoc()) {
            $xRating = $row['x_rating'];
            $yRating = $row['y_rating'];

            $sumX += $xRating;
            $sumY += $yRating;
            $sumXY += $xRating * $yRating;
            $sumX2 += $xRating ** 2;
            $sumY2 += $yRating ** 2;
            $n++;
        }

        if ($n === 0) return 0; // No common rated items

        $numerator = $sumXY - ($sumX * $sumY / $n);
        $denominator = sqrt(($sumX2 - ($sumX ** 2 / $n)) * ($sumY2 - ($sumY ** 2 / $n)));

        $similarity = $denominator ? $numerator / $denominator : 0;

        // Debugging: log similarity score
        echo "Similarity between user $x and user $y: $similarity\n";

        return $similarity;
    }

    /**
     * Generate recommendations for a user (x) by aggregating ratings from similar users.
     */
    public function getRecommendations($x) {
        // Fetch all distinct users except x
        $query = "SELECT DISTINCT user_id FROM ratings WHERE user_id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $x);
        $stmt->execute();
        $result = $stmt->get_result();

        $similarities = [];

        while ($row = $result->fetch_assoc()) {
            $y = $row['user_id'];
            $similarities[$y] = $this->calculateSimilarity($x, $y);
        }

        // Debugging: log similarities
        echo "Similarities: ";
        print_r($similarities);

        // Weighted rating aggregation
        $weightedRatings = [];
        $similaritySums = [];

        foreach ($similarities as $y => $similarity) {
            if ($similarity <= 0) continue; // Ignore non-similar users

            $query = "SELECT hotel_id, rating FROM ratings WHERE user_id = ? AND hotel_id NOT IN (
                        SELECT hotel_id FROM ratings WHERE user_id = ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $y, $x);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $hotelId = $row['hotel_id'];
                $rating = $row['rating'];

                if (!isset($weightedRatings[$hotelId])) {
                    $weightedRatings[$hotelId] = 0;
                    $similaritySums[$hotelId] = 0;
                }

                $weightedRatings[$hotelId] += $similarity * $rating;
                $similaritySums[$hotelId] += $similarity;
            }
        }

        // Debugging: log weighted ratings and similarity sums
        echo "Weighted Ratings: ";
        print_r($weightedRatings);
        echo "Similarity Sums: ";
        print_r($similaritySums);

        // Calculate final scores
        $recommendations = [];
        foreach ($weightedRatings as $hotelId => $totalWeightedRating) {
            $recommendations[$hotelId] = $totalWeightedRating / $similaritySums[$hotelId];
        }

        // Sort recommendations by score
        arsort($recommendations);

        echo "Sorted Recommendations: ";
        print_r($recommendations);

        // Fetch hotel details
        $hotelIds = array_keys($recommendations);
        if (empty($hotelIds)) {
            echo "No recommendations available.";
            return [];
        }

        $placeholders = implode(",", array_fill(0, count($hotelIds), "?"));
        $query = "SELECT * FROM hotels WHERE hotel_id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(str_repeat("i", count($hotelIds)), ...$hotelIds);
        $stmt->execute();
        $result = $stmt->get_result();

        $recommendedHotels = [];
        while ($row = $result->fetch_assoc()) {
            $hotelId = $row['hotel_id'];
            $row['score'] = $recommendations[$hotelId];
            $recommendedHotels[] = $row;
        }

        return $recommendedHotels;
    }
}

// Example usage
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$x = $_SESSION['user_id'];
$recommender = new CollaborativeFiltering($conn);
$recommendedHotels = $recommender->getRecommendations($x);
print_r($recommendedHotels);
// Output recommendations

?>

<?php
include '../database/db.php'; 
include 'collaborative_filtering.php';
include 'content_based_filtering.php';
include 'decision_tree.php';
include 'includes/header.php'; 
$user_id = $_SESSION['user_id'];

// Collaborative Filtering
$collaborative_recommendations = getCollaborativeRecommendations($user_id, $conn);

// Content-Based Filtering
$content_recommendations = getContentBasedRecommendations($user_id, $conn);

// Decision Tree
$decisionTree = new DecisionTree();
$decision_recommendation = $decisionTree->makeRecommendation('low', 'trekking');
?>


<div class="container my-5">

    <!-- Collaborative Recommendations Section -->
    <h3 class="text-center mb-4">Collaborative Recommendations</h3>
    <div class="row">
        <?php foreach ($collaborative_recommendations as $hotel_id): ?>
            <?php
            // Fetch hotel details using the hotel ID
            $stmt = $conn->prepare("SELECT hotel_id, hotel_name, image_url, amenities, price_per_night FROM hotels WHERE hotel_id = ?");
            $stmt->bind_param("i", $hotel_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $hotel = $result->fetch_assoc();
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card position-relative">
                    <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($hotel['hotel_name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($hotel['hotel_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($hotel['amenities']); ?></p>
                        <span class="hotel-price position-absolute bottom-0 end-0 m-3 bg-primary text-white p-2 rounded">
                            $ <?php echo htmlspecialchars($hotel['price_per_night']); ?>
                        </span>
                        <a href="hotel_details.php?hotel_id=<?php echo $hotel['hotel_id']; ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Content-Based Recommendations Section -->
    <h3 class="text-center mb-4">Content-Based Recommendations</h3>
    <div class="row">
        <?php foreach ($content_recommendations as $recommendation): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card position-relative">
                    <img src="<?php echo htmlspecialchars($recommendation['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recommendation['hotel_name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($recommendation['hotel_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($recommendation['amenities']); ?></p>
                        <a href="hotel_details.php?hotel_id=<?php echo $recommendation['hotel_id']; ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Decision Tree Recommendation Section -->
    <h3 class="text-center mb-4">Decision Tree Recommendation</h3>
    <div class="alert alert-info text-center">
        <p><?php echo htmlspecialchars($decision_recommendation); ?></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

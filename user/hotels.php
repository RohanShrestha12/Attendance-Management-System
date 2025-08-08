<?php include 'includes/header.php'; ?>
<?php include 'includes/functions.php'; ?>

<div class="container my-5">
    <h3 class="text-center mb-4">Explore Hotels</h3>
    <div class="row">
        <?php
        $hotels = fetch_hotels();
        foreach ($hotels as $hotel) {
            // Format price with '$' symbol and 2 decimal places
            $price = !empty($hotel['price_per_night']) ? '$' . number_format($hotel['price_per_night'], 2) : 'Price not available';

            echo "
            <div class='col-lg-4 col-md-6 mb-4'>
                <div class='card'>
                    <img src='{$hotel['image_url']}' class='card-img-top' alt='" . htmlspecialchars($hotel['hotel_name']) . "'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($hotel['hotel_name']) . "</h5>
                        <p class='card-text'>" . htmlspecialchars($hotel['amenities']) . "</p>
                        <p class='hotel-price'>{$price}</p> <!-- Display price here -->
                        <a href='#' class='btn btn-primary'>Book Now</a>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

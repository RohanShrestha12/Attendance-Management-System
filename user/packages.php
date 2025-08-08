<?php include 'includes/header.php'; ?>
<?php include 'includes/functions.php'; ?>

<div class="container my-5">
    <h3 class="text-center mb-4">Special Packages</h3>
    <div class="row">
        <?php
        $packages = fetch_packages();
        foreach ($packages as $package) {
            // Format price with '$' symbol and 2 decimal places
            $price = !empty($package['price']) ? '$' . number_format($package['price'], 2) : 'Price not available';

            echo "
            <div class='col-lg-4 col-md-6 mb-4'>
                <div class='card'>
                    <img src='" . htmlspecialchars($package['image_url']) . "' class='card-img-top' alt='" . htmlspecialchars($package['package_name']) . "'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($package['package_name']) . "</h5>
                        <p class='card-text'>" . htmlspecialchars($package['description']) . "</p>
                        <p class='card-text'>" . htmlspecialchars($package['amenities']) . "</p>
                        <p class='card-text'>" . htmlspecialchars($price) . "</p>
                        <a href='#' class='btn btn-primary'>Book Now</a> <!-- Book Now button -->
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/functions.php'; ?>

<div class="container my-5">
    <h3 class="text-center mb-4">Discover Locations</h3>
    <div class="row">
        <?php
        $locations = fetch_locations(); 
           foreach ($locations as $location) {
            echo "
            <div class='col-lg-4 col-md-6 mb-4'>
                <div class='card'>
                    <img src='{$location['image_url']}' class='card-img-top' alt='{$location['location_name']}'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$location['location_name']}</h5>
                        <p class='card-text'>{$location['category']}</p>
                         <p class='card-text'>{$location['description']}</p>
                    
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

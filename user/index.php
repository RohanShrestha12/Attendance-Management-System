    <?php
    include 'includes/header.php';
    include 'includes/functions.php';
    include '../database/db.php';

    // Initialize search and recommended results arrays
    $searchResults = [];
    $recommendedResults = [];

    // Handle search query
    if (isset($_GET['query'])) {
        $query = htmlspecialchars($_GET['query']);
        $searchResults = search_all($query); // Search hotels, locations, and packages
    }

    // Check if user is logged in
    $isUserLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

    if ($isUserLoggedIn) {
        // Fetch preferences, ratings, all hotels, and booked hotels for the logged-in user
        $userPreferences = fetch_user_preferences($conn, $_SESSION['user_id']);
        $ratedHotels = fetch_rated_hotels($conn, $_SESSION['user_id']);
        $allUserRatings = fetch_all_user_ratings($conn); // All users' ratings for collaborative filtering
        $hotels = fetch_hotels(); // Fetch all hotels
        $bookedHotels = fetch_booked_hotels($conn, $_SESSION['user_id']); // Fetch hotels booked by the user

        // Run hybrid algorithm to recommend hotels
        $recommendedHotels = hybrid_algorithm($userPreferences, $ratedHotels, $allUserRatings, $hotels, $conn);
    }

    // Show booking button only if the user is logged in
    $bookingButton = $isUserLoggedIn
        ? "<button class='btn btn-primary btn-book-now' data-bs-toggle='modal' data-bs-target='#bookingModal'>Book Now</button>"
        : "";

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Ratings</title>
    <style>
        .star {
            font-size: 24px;
            cursor: pointer;
        }

        .inactive {
            color: #ddd;
        }

        .star:not(.inactive) {
            color: #ffcc00;
        }
    </style>
</head>
<body>
<a href="includes/collaborative_filtering2.php">click here</a>
<div class="container my-5">
    <?php if (isset($_SESSION['user_id'])): ?>
        <h3 class="text-center mb-4">Recommended Hotels for You</h3>
        <div class="row">
            <?php if (!empty($recommendedHotels)): ?>
                <?php foreach ($recommendedHotels as $hotel): ?>
                    <?php
                    $hotelId = $hotel['hotel_id'] ?? null;
                    $imageUrl = $hotel['image_url'] ?? 'defaultimage.jpeg'; // Default image
                    $hotelName = $hotel['hotel_name'] ?? 'Unknown Hotel'; // Default hotel name
                    $amenities = $hotel['amenities'] ?? 'No amenities listed';
                    $price = isset($hotel['price_per_night']) ? '$' . number_format($hotel['price_per_night'], 2) : 'Price not available';
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($imageUrl); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($hotelName); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($hotelName); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($amenities); ?></p>
                                <p class="hotel-price"><?php echo htmlspecialchars($price); ?></p>
                                <?php if ($hotelId): ?>
                                    <button class="btn btn-primary book-now"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bookingModal"
                                        data-hotel-id="<?php echo $hotelId; ?>"
                                        data-hotel-name="<?php echo htmlspecialchars($hotelName); ?>"
                                        data-price="<?php echo htmlspecialchars($price); ?>">
                                        Book Now
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
        

                <?php else: ?>
                    <p>No recommendations available.</p>
                <?php endif; ?>
            </div>
            
            <!-- Booking Modal -->
            <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel">Book Hotel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="booking.php" method="POST">
                                <input type="hidden" name="hotel_id" id="hotelId">
                                <div class="mb-3">
                                    <label for="hotelName" class="form-label">Hotel Name</label>
                                    <input type="text" class="form-control" id="hotelName" name="hotel_name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="pricePerNight" class="form-label">Price Per Night</label>
                                    <input type="text" class="form-control" id="pricePerNight" name="price_per_night" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="checkInDate" class="form-label">Check-In Date</label>
                                    <input type="date" class="form-control" id="checkInDate" name="check_in_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="checkOutDate" class="form-label">Check-Out Date</label>
                                    <input type="date" class="form-control" id="checkOutDate" name="check_out_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="totalAmount" class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="totalAmount" name="total_amount" readonly>
                                </div>
                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Show Visited (Booked) Hotels for Logged-in Users -->
       <!-- Show Visited (Booked) Hotels for Logged-in Users -->
       <h2 class="mt-4 text-center">Visited Hotels</h2>
    <div class="row">
        <?php if (!empty($bookedHotels)): ?>
            <?php foreach ($bookedHotels as $bookedhotel): ?>
                <?php
                $imageUrl = $bookedhotel['image_url'] ?? 'defaultimage.jpeg';
                $hotelName = $bookedhotel['hotel_name'] ?? 'Unknown Hotel';
                $amenities = $bookedhotel['amenities'] ?? 'No amenities listed';
                $price = isset($bookedhotel['price_per_night']) ? '$' . number_format($bookedhotel['price_per_night'], 2) : 'Price not available';
                $rating = $bookedhotel['rating'] ?? 'Not calculated';
                $hotelId = $bookedhotel['hotel_id'] ?? 0; // Unique hotel ID
                $userRating = $bookedhotel['user_rating'] ?? 0; // User rating
                ?>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                             alt="<?php echo htmlspecialchars($hotelName); ?>" 
                             class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($hotelName); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($amenities); ?></p>
                            <p>Price per night: <strong><?php echo htmlspecialchars($price); ?></strong></p>
                            <p>Rating: <strong><?php echo htmlspecialchars($rating); ?></strong></p>

                            <!-- Star Rating System -->
                            <div class="star-rating" 
                                 data-hotel-id="<?php echo htmlspecialchars($hotelId); ?>" 
                                 data-user-rating="<?php echo htmlspecialchars($userRating); ?>">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo ($userRating >= $i) ? '' : 'inactive'; ?>" 
                                          data-value="<?php echo $i; ?>">★</span>
                                <?php endfor; ?>
                            </div>

                            <p>User Rating: <strong><?php echo htmlspecialchars($userRating); ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No visited hotels found.</p>
        <?php endif; ?>
    </div>

        <?php else: ?>
            <!-- Show Hotels, Locations, and Packages for Unlogged Users -->
            <h3 class="text-center mb-4">Popular Hotels</h3>
            <div class="row">
                <?php
                $hotels = fetch_hotels(6); // Fetch 6 hotels for unlogged users

                foreach ($hotels as $hotel) {
                    $imageUrl = !empty($hotel['image_url']) ? $hotel['image_url'] : 'defaultimage.jpeg';
                    $hotelName = !empty($hotel['hotel_name']) ? $hotel['hotel_name'] : 'Unknown Hotel';
                    $amenities = !empty($hotel['amenities']) ? $hotel['amenities'] : 'No amenities listed';
                    $price = !empty($hotel['price_per_night']) ? '$' . number_format($hotel['price_per_night'], 2) : 'Price not available';

                    echo "
                    <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='card'>
                            <img src='".htmlspecialchars($imageUrl)."' class='card-img-top' alt='".htmlspecialchars($hotelName)."'>
                            <div class='card-body'>
                                <h5 class='card-title'>".htmlspecialchars($hotelName)."</h5>
                                <p class='card-text'>".htmlspecialchars($amenities)."</p>
                                <p class='hotel-price'>".htmlspecialchars($price)."</p>
                                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#bookingModal' data-hotel-name='".htmlspecialchars($hotelName)."' data-price='".htmlspecialchars($price)."'>Book Now</button>
                            </div>
                        </div>
                    </div>
                    ";
                }
                
                ?>
            </div>
            <h3 class="text-center mb-4">Explore Location</h3>
            <div class="row">
                <?php
                $locations = fetch_locations(6); // Fetch 6 hotels for unlogged users

                foreach ($locations as $location) {
                    $imageUrl = !empty($location['image_url']) ? $location['image_url'] : 'defaultimage.jpeg';
                    $locationName = !empty($location['location_name']) ? $location['location_name'] : 'Unknown Location';
                    $category = !empty($location['category']) ? $location['category'] : 'No categories listed';
                    $description = !empty($location['description']) ? $location['description'] :'description not available';

                    echo "
                    <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='card'>
                            <img src='".htmlspecialchars($imageUrl)."' class='card-img-top' alt='".htmlspecialchars($locationName)."'>
                            <div class='card-body'>
                                <h5 class='card-title'>".htmlspecialchars($locationName)."</h5>
                                <p class='card-text'>".htmlspecialchars($category)."</p>
                                <p class='hotel-price'>".htmlspecialchars($description)."</p>
                            
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>

            <h3 class="text-center mb-4">Explore Packages</h3>
    <div class="row">
        <?php
        $packages = fetch_packages(6); // Fetch 6 packages for unlogged users

        foreach ($packages as $package) {
            $imageUrl = !empty($package['image_url']) ? $package['image_url'] : 'defaultimage.jpeg';
            $packageName = !empty($package['package_name']) ? $package['package_name'] : 'Unknown Package';
            $price = !empty($package['price']) ? '$' . number_format($package['price'], 2) : 'Price not available';
            $duration = !empty($package['duration']) ? htmlspecialchars($package['duration']) : 'Duration not available';
            $description = !empty($package['description']) ? htmlspecialchars($package['description']) : 'Description not available';
            $amenities = !empty($package['amenities']) ? htmlspecialchars($package['amenities']) : 'No amenities listed';

            echo "
            
            <div class='col-lg-4 col-md-6 mb-4'>
                <div class='card'>
                    <div class='card-body'>
    <img src='".htmlspecialchars($imageUrl)."' class='card-img-top' alt='".htmlspecialchars($packageName)."'>
                        <h5 class='card-title'>".htmlspecialchars($packageName)."</h5>
                        <p class='card-text'>Price: $price</p>
                        <p class='card-text'>Duration: $duration</p>
                        <p class='card-text'>Description: $description</p>
                        <p class='card-text'>Amenities: $amenities</p>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>
        <?php endif; ?>
    </div>

 


    <script>

document.addEventListener('DOMContentLoaded', function () {
            const starContainers = document.querySelectorAll('.star-rating');

            starContainers.forEach(container => {
                const stars = container.querySelectorAll('.star');
                const hotelId = container.getAttribute('data-hotel-id');
                
                // Get the initial user rating for this hotel
                const userRating = parseInt(container.getAttribute('data-user-rating')) || 0;
                updateStars(userRating);

                stars.forEach(star => {
                    star.addEventListener('click', function () {
                        const rating = parseInt(this.getAttribute('data-value'));
                        console.log('Submitting rating:', { hotel_id: hotelId, rating: rating });

                        fetch('rate_hotel.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ hotel_id: hotelId, rating: rating })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update star appearance
                                    updateStars(rating);
                                    alert('Rating submitted successfully!');
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // Function to update the stars display based on rating
                function updateStars(rating) {
                    stars.forEach(s => {
                        const starRating = parseInt(s.getAttribute('data-value'));
                        if (starRating <= rating) {
                            s.classList.remove('inactive'); // Fill star
                        } else {
                            s.classList.add('inactive'); // Empty star
                        }
                    });
                }
            });
        });

 
        // Set the booking modal fields when the booking button is clicked
        const bookingButtons = document.querySelectorAll('.book-now');
        bookingButtons.forEach(button => {
            button.addEventListener('click', () => {
                const hotelName = button.getAttribute('data-hotel-name');
                const pricePerNight = parseFloat(button.getAttribute('data-price').replace(/[$,]/g, ''));
                document.getElementById('hotelName').value = hotelName;
                document.getElementById('pricePerNight').value = button.getAttribute('data-price');
                document.getElementById('totalAmount').value = ''; // Reset total amount
                document.getElementById('hotelId').value = button.getAttribute('data-hotel-id');
            });
        });

        // Calculate total amount based on input values
    // Calculate total amount based on input values
    function calculateTotalAmount() {
        const checkInDate = new Date(document.getElementById('checkInDate').value);
        const checkOutDate = new Date(document.getElementById('checkOutDate').value);
        const pricePerNight = parseFloat(document.getElementById('pricePerNight').value.replace(/[$,]/g, ''));
       

        if (!isNaN(checkInDate.getTime()) && !isNaN(checkOutDate.getTime()) && !isNaN(pricePerNight)) {
            const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 3600 * 24));
            
            if (nights > 0) {
                const totalAmount = nights * pricePerNight ;
                document.getElementById('totalAmount').value = '$' + totalAmount.toFixed(2);

                // Log for debugging
                console.log('Total Amount:', totalAmount);
            } else {
                document.getElementById('totalAmount').value = '';
            }
        }
    }


        // Add event listeners to calculate total amount on input change
        document.getElementById('checkInDate').addEventListener('change', calculateTotalAmount);
        document.getElementById('checkOutDate').addEventListener('change', calculateTotalAmount);
        document.getElementById('numGuests').addEventListener('change', calculateTotalAmount);

      // JavaScript to handle star rating interaction
      

    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php
    include 'includes/footer.php';
    ?>

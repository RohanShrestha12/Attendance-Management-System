    <?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Personalized Tour Recommendation</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Custom CSS -->
        <style>
        .card-img-top {
            width: 100%;
            height: 200px; /* Set a fixed height */
            object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
        }

        .card {
            height: 100%; /* Ensure all cards have the same height */
            display: flex;
            flex-direction: column;
        }
        .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa; /* Optional light background for the footer area */
}

/* Style for the Book Now button */
.btn-book-now {
    background-color: #007bff; /* Bootstrap primary button color */
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

/* Hover effect for Book Now button */
.btn-book-now:hover {
    background-color: #0056b3;
}

        .card-body {
            flex-grow: 1; /* Ensure card body grows to fill available space */
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px;
        }

        .hotel-price, .package-price {
            font-size: 1rem;
    font-weight: bold;
    color: #333; /* Darker, neutral color */
    padding: 0; /* Remove padding */
    border: none; /* No border */
    background: none; /* No background color */
        }

        .col-lg-4, .col-md-6 {
            margin-bottom: 20px;
        }

        .search-bar {
            width: 300px;
        }
      
        .star-rating {
            display: flex;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .star {
            font-size: 24px;
            color: gold;
        }
        .star.inactive {
            color: lightgray;
        }

        </style>

    </head>
    <body>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <!-- Brand aligned to the left corner -->
                <a class="navbar-brand mr-auto" href="index.php">Tours & Travels</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Left-side links -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="hotels.php"><i class="fas fa-hotel"></i> Hotels</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="locations.php"><i class="fas fa-map-marker-alt"></i> Locations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="packages.php"><i class="fas fa-box"></i> Packages</a>
                        </li>
                    </ul>
                    
                    <!-- Search Bar -->
                    <form class="form-inline my-2 my-lg-0" action="includes/search.php" method="GET">
                        <input class="form-control mr-sm-2 search-bar" type="search" name="query" placeholder="Search hotels, locations..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <!-- Right-side links -->
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <li class="nav-item">
                                <span class="navbar-text">Welcome, <?php echo $_SESSION['username']; ?>!</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="includes/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i> Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/login_process.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span>Don't have an account? <a href="#" data-toggle="modal" data-target="#signupModal" data-dismiss="modal">Sign up here</a></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signup Modal -->
        <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/signup.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

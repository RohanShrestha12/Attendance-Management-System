<?php
include 'header.php';
include 'sidebar.php';
include 'functions.php';

$bookings = getBookings();
?>

<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <h2>Manage Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Hotel</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = mysqli_fetch_assoc($bookings)): ?>
                <tr>
                    <td><?php echo $booking['booking_id']; ?></td>
                    <td><?php echo $booking['user_id']; ?></td>
                    <td><?php echo $booking['hotel_id']; ?></td>
                    <td><?php echo $booking['status']; ?></td>
                    <td>
                        <?php if ($booking['status'] == 'Pending'): ?>
                            <a href="confirm_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                            <a href="cancel_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div> <!-- Closing container div from sidebar.php -->
</div> <!-- Closing row div from sidebar.php -->
</div> <!-- Closing container-fluid div from sidebar.php -->
</body>
</html>

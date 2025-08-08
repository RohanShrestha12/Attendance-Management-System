<!-- manage_bookings.php -->
<?php
include 'db.php';
$result = $conn->query("SELECT * FROM bookings");
?>

<h3>Manage Bookings</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Package ID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($booking = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $booking['booking_id']; ?></td>
                <td><?= $booking['user_id']; ?></td>
                <td><?= $booking['package_id']; ?></td>
                <td><?= $booking['status']; ?></td>
                <td>
                    <?php if ($booking['status'] == 'Pending') { ?>
                        <button class="btn btn-success confirm-booking" data-id="<?= $booking['booking_id']; ?>">Confirm</button>
                        <button class="btn btn-danger cancel-booking" data-id="<?= $booking['booking_id']; ?>">Cancel</button>
                    <?php } else {
                        echo $booking['status'];
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

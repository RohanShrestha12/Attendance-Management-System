<?php
include '../database/db.php';// Database connection

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "
    <tr>
        <td>{$row['user_id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>{$row['role']}</td>
        <td>
            <button class='btn btn-warning btn-sm editUser' data-id='{$row['user_id']}'>Edit</button>
            <button class='btn btn-danger btn-sm deleteUser' data-id='{$row['user_id']}'>Delete</button>
        </td>
    </tr>
    ";
}
?>

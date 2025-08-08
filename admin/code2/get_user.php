<?php
include '../database/db.php';

$user_id = $_POST['user_id'];
$query = "SELECT * FROM users WHERE user_id='$user_id'";
$result = $conn->query($query);

if ($result) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
}
?>

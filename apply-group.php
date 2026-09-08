<?php
session_start();
require 'includes/database.php';

$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];

$group_requests_sql = "SELECT * FROM group_requests
                       WHERE user_id = $user_id
                       AND group_id = $group_id";

$group_requests_result = $conn->query($group_requests_sql);

if ($group_requests_result->num_rows > 0) {
    header("Location: index.php");
    exit;
}

$group_requests_sql = "INSERT INTO group_requests (user_id, group_id)
                       VALUES ($user_id, $group_id)";

$conn->query($group_requests_sql);
header("Location: index.php");

exit;

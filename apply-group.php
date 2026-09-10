<?php
session_start();
require 'includes/database.php';

$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];

$group_requests_stmt = $conn->prepare("SELECT * FROM group_requests WHERE user_id = ? AND group_id = ?");
$group_requests_stmt->bind_param("ii", $user_id, $group_id);
$group_requests_stmt->execute();
$group_requests_result = $group_requests_stmt->get_result();

if ($group_requests_result->num_rows > 0) {
    header("Location: index.php");
    exit;
}

$group_requests_stmt = $conn->prepare("INSERT INTO group_requests (user_id, group_id) VALUES (?, ?)");
$group_requests_stmt->bind_param("ii", $user_id, $group_id);
$group_requests_stmt->execute();
header("Location: index.php");

exit;

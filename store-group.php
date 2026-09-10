<?php

session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$name = $_POST['name'];
$description = $_POST['description'];
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO `groups` (name, description) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $description);

if ($stmt->execute()) {
    $groupId = $conn->insert_id;

    $memberStmt = $conn->prepare(
        "INSERT INTO user_groups (user_id, group_id) VALUES (?, ?)"
    );

    $memberStmt->bind_param("ii", $userId, $groupId);
    $memberStmt->execute();
}

header('Location: index.php');
exit;
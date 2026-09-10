<?php

session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$name = $_POST['name'];
$description = $_POST['description'];

$stmt = $conn->prepare("INSERT INTO `groups` (name, description) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $description);
$stmt->execute();

header('Location: index.php');
exit;
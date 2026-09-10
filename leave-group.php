<?php
session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];

$stmt = $conn->prepare("DELETE FROM user_groups WHERE user_id = ? AND group_id = ?");
$stmt->bind_param("ii", $user_id, $group_id);
$stmt->execute();

header('Location: index.php');
exit;

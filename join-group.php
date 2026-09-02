<?php

session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];

$sql = "INSERT INTO user_groups (user_id, group_id)
        VALUES ($user_id, $group_id)";

$conn->query($sql);

header('Location: group.php');
exit;
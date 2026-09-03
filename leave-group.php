<?php

require 'includes/database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];

$sql = "DELETE FROM user_groups
        WHERE user_id = $user_id
        AND group_id = $group_id";

$conn->query($sql);

header('Location: index.php');
exit;

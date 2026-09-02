<?php

session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$name = $_POST['name'];
$description = $_POST['description'];

$sql = "INSERT INTO `groups` (name, description)
        VALUES ('$name', '$description')";

$conn->query($sql);

header('Location: index.php');
exit;
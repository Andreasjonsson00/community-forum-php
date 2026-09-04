<?php
session_start();
require "includes/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user_id'];
    $groupId = $_POST['group_id'];
    $subject = trim($_POST['subject']);
    $content = trim($_POST['content']);

    if (empty($subject) || empty($content)) {
        echo "<p>Subject and content are required.</p>";
        exit;
    }

    $sql = "INSERT INTO discussions (user_id, group_id, subject, content, created_at)
            VALUES ('$userId', '$groupId', '$subject', '$content', NOW())";

    if ($conn->query($sql)) {
        header("Location: group.php?id=$groupId");
        exit;
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

<?php
session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$discussion_id = $_POST['discussion_id'];
$content = $_POST['content'];

$sql = "SELECT group_id FROM discussions WHERE id = $discussion_id";
$result = $conn->query($sql);

$discussion = $result->fetch_assoc();

if (!$discussion) {
    die("Diskussionen finns inte.");
}

$group_id = $discussion['group_id'];

$sql = "SELECT * FROM user_groups
        WHERE user_id = $user_id
        AND group_id = $group_id";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Du är inte medlem i gruppen.");
}

$sql = "INSERT INTO posts (content, discussion_id, user_id, created_at)
        VALUES ('$content', $discussion_id, $user_id, NOW())";

$conn->query($sql);

header('Location: discussion.php?id=' . $discussion_id);
exit;

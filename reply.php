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

$discussion_stmt = $conn->prepare("SELECT group_id FROM discussions WHERE id = ?");
$discussion_stmt->bind_param("i", $discussion_id);
$discussion_stmt->execute();
$result = $discussion_stmt->get_result();

$discussion = $result->fetch_assoc();

if (!$discussion) {
    die("Diskussionen finns inte.");
}

$group_id = $discussion['group_id'];

$member_stmt = $conn->prepare("SELECT * FROM user_groups WHERE user_id = ? AND group_id = ?");
$member_stmt->bind_param("ii", $user_id, $group_id);
$member_stmt->execute();
$result = $member_stmt->get_result();

if ($result->num_rows === 0) {
    die("Du är inte medlem i gruppen.");
}

$post_stmt = $conn->prepare("INSERT INTO posts (content, discussion_id, user_id, created_at) VALUES (?, ?, ?, NOW())");
$post_stmt->bind_param("sii", $content, $discussion_id, $user_id);
$post_stmt->execute();

header('Location: discussion.php?id=' . $discussion_id);
exit;

<?php
session_start();
require "includes/database.php";

$user_id = $_SESSION['user_id'];
$request_id = $_POST['request_id'];

$request_stmt = $conn->prepare("SELECT * FROM group_requests WHERE id = ?");
$request_stmt->bind_param("i", $request_id);
$request_stmt->execute();
$request_result = $request_stmt->get_result();
$request = $request_result->fetch_assoc();

if (!$request) {
    header("Location: index.php");
    exit;
}

$group_id = $request['group_id'];
$member_stmt = $conn->prepare("SELECT * FROM user_groups WHERE user_id = ? AND group_id = ?");
$member_stmt->bind_param("ii", $user_id, $group_id);
$member_stmt->execute();
$member_result = $member_stmt->get_result();

if ($member_result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$requested_user_id = $request['user_id'];

$insert_stmt = $conn->prepare("INSERT INTO user_groups (user_id, group_id) VALUES (?, ?)");
$insert_stmt->bind_param("ii", $requested_user_id, $group_id);
$insert_stmt->execute();

$delete_stmt = $conn->prepare("DELETE FROM group_requests WHERE id = ?");
$delete_stmt->bind_param("i", $request_id);
$delete_stmt->execute();

header("Location: group.php?id=$group_id");
exit;
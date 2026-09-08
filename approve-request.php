<?php
session_start();
require "includes/database.php";

$user_id = $_SESSION['user_id'];
$request_id = $_POST['request_id'];

$request_sql = "SELECT * FROM group_requests
                WHERE id = $request_id";

$request_result = $conn->query($request_sql);
$request = $request_result->fetch_assoc();

$group_id = $request['group_id'];
$member_sql = "SELECT * FROM user_groups
               WHERE user_id = $user_id
               AND group_id = $group_id";

$member_result = $conn->query($member_sql);

if ($member_result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$requested_user_id = $request['user_id'];

$insert_sql = "INSERT INTO user_groups (user_id, group_id)
               VALUES ($requested_user_id, $group_id)";

$conn->query($insert_sql);

$delete_sql = "DELETE FROM group_requests
               WHERE id = $request_id";

$conn->query($delete_sql);

header("Location: group.php?id=$group_id");
exit;
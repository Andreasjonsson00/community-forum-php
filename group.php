<?php
session_start();
require "includes/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$groupId = $_GET['id'];
$userId = $_SESSION['user_id'];

$member_sql = "SELECT * FROM user_groups
               WHERE user_id = $userId
               AND group_id = $groupId";
$member_result = $conn->query($member_sql);

if ($member_result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$requests_sql = "SELECT group_requests.*, users.first_name, users.last_name
                 FROM group_requests
                 JOIN users ON group_requests.user_id = users.id
                 WHERE group_requests.group_id = $groupId";

$requests_result = $conn->query($requests_sql);

$group_sql = "SELECT * FROM `groups` 
              WHERE id = $groupId";

$group_result = $conn->query($group_sql);
$group = $group_result->fetch_assoc();

$discussion_sql = "SELECT discussions.id AS discussion_id,
                          discussions.group_id,
                          discussions.user_id,
                          discussions.subject,
                          discussions.created_at,
                          discussions.content,
                          users.first_name,
                          users.last_name
                  FROM discussions
                  JOIN users ON discussions.user_id = users.id
                  WHERE discussions.group_id = $groupId
                  ORDER BY discussions.created_at DESC";

$discussion_result = $conn->query($discussion_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($group['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php require "includes/menu.php"; ?>
    <main>
        <h1><?= htmlspecialchars($group['name']) ?></h1>
        <p class="description">
            <?= htmlspecialchars($group['description']) ?>
        </p>

        <?php if (isset($_SESSION['user_id'])): ?>

            <a href="create-discussion.php?group_id=<?= $group['id'] ?>">
                <button class="new-discussion-button" type="button">New Discussion</button>
            </a>
        <?php endif; ?>


        <?php while ($discussion = $discussion_result->fetch_assoc()): ?>

            <?php
            $discussionId = $discussion['discussion_id'];

            $posts_sql = "SELECT posts.*, users.first_name, users.last_name
              FROM posts
              JOIN users ON posts.user_id = users.id
              WHERE posts.discussion_id = $discussionId
              ORDER BY posts.created_at ASC";

            $posts_result = $conn->query($posts_sql);
            ?>

            <div class="discussion">
                <h3>
                    <a href="discussion.php?id=<?= $discussion['discussion_id'] ?>">
                        <?= htmlspecialchars($discussion['subject']) ?>
                    </a>
                </h3>
                <p><?= htmlspecialchars($discussion['content']) ?></p>
                <div class="discussion-meta">
                    <p><?= htmlspecialchars(ucfirst(strtolower($discussion['first_name']))) ?>
                        <?= htmlspecialchars(ucfirst(strtolower($discussion['last_name']))) ?></p>
                    <p class="created-at"><?= htmlspecialchars($discussion['created_at']) ?></p>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if ($requests_result->num_rows > 0): ?>
            <h2>Membership Requests</h2>
            <?php while ($request = $requests_result->fetch_assoc()): ?>
                <div>
                    <p>
                        <?= htmlspecialchars(ucfirst(strtolower($request['first_name']))) ?>
                        <?= htmlspecialchars(ucfirst(strtolower($request['last_name']))) ?>
                    </p>

                    <form action="approve-request.php" method="POST">
                        <input
                            type="hidden"
                            name="request_id"
                            value="<?= $request['id'] ?>">
                        <button type="submit">Approve</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
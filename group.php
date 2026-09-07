<?php
session_start();
require "includes/database.php";

$groupId = $_GET['id'];
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
                    <p><?= htmlspecialchars($discussion['created_at']) ?></p>
                    <p><?= ucfirst(strtolower($discussion['first_name'])) ?>
                        <?= ucfirst(strtolower($discussion['last_name'])) ?></p>
                </div>
            <?php endwhile; ?>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
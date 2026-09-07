<?php
session_start();
require "includes/database.php";

$groupId = $_GET['id'];
$group_sql = "SELECT * FROM `groups` 
              WHERE id = $groupId";
$group_result = $conn->query($group_sql);
$group = $group_result->fetch_assoc();


$discussion_sql = "SELECT * FROM discussions
                  JOIN users ON discussions.user_id = users.id
                  WHERE discussions.group_id = $groupId
                  ORDER BY created_at DESC";
$discussion_result = $conn->query($discussion_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum</title>
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
            <h2>New Discussion</h2>

            <form action="create-discussion.php" method="POST">
                <input type="hidden" name="group_id" value="<?= $group['id'] ?>">

                <div class="form-row">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>

                <div class="form-row">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" required></textarea>
                </div>

                <div class="create-discussion-button">
                    <button type="submit">New Discussion</button>
                </div>
            </form>
        <?php endif; ?>


        <?php while ($discussion = $discussion_result->fetch_assoc()): ?>

            <?php
            $discussionId = $discussion['id'];

            $posts_sql = "SELECT posts.*, users.first_name, users.last_name
              FROM posts
              JOIN users ON posts.user_id = users.id
              WHERE posts.discussion_id = $discussionId
              ORDER BY posts.created_at ASC";

            $posts_result = $conn->query($posts_sql);
            ?>

            <article>
                <div class="discussion">
                    <h3>
                        <a href="discussion.php?id=<?= $discussion['id'] ?>">
                            <?= htmlspecialchars($discussion['subject']) ?>
                        </a>
                    </h3>
                    <p><?= htmlspecialchars($discussion['content']) ?></p>
                    <p>Created at: <?= htmlspecialchars($discussion['created_at']) ?></p>
                    <p>Created by: <?= htmlspecialchars($discussion['first_name']) ?>
                        <?= htmlspecialchars($discussion['last_name']) ?></p>
                </div>
            <?php endwhile; ?>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
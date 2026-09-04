<?php
session_start();
require "includes/database.php";

$groupId = $_GET['id'];
$group_sql = "SELECT * FROM `groups` 
              WHERE id = $groupId";
$group_result = $conn->query($group_sql);
$group = $group_result->fetch_assoc();


$discussion_sql = "SELECT * FROM discussions
                  WHERE group_id = $groupId
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
            <h2>Create Discussion</h2>

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
                    <button type="submit">Create Discussion</button>
                </div>
            </form>
        <?php endif; ?>

        <h2>Discussions</h2>

        <?php while ($discussion = $discussion_result->fetch_assoc()): ?>

            <article>
                <h3><?= htmlspecialchars($discussion['subject']) ?></h3>
                <p><?= htmlspecialchars($discussion['content']) ?></p>
            </article>

        <?php endwhile; ?>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
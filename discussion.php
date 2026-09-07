<?php
session_start();
require "includes/database.php";

$discussionId = $_GET['id'];

$discussion_sql = "SELECT discussions.*, 
                          users.first_name, 
                          users.last_name
                   FROM discussions
                   JOIN users ON discussions.user_id = users.id
                   WHERE discussions.id = $discussionId";

$discussion_result = $conn->query($discussion_sql);
$discussion = $discussion_result->fetch_assoc();

if (!$discussion) {
    die("Diskussionen finns inte.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($discussion['subject']) ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php require "includes/menu.php"; ?>

    <main>
            <div class="discussion">
                <h1><?= htmlspecialchars($discussion['subject']) ?></h1>
                <p class="description">
                    <?= htmlspecialchars($discussion['content']) ?>
                </p>
                <p>
                    <?= htmlspecialchars($discussion['created_at']) ?>
                </p>
                <p>
                    <?= ucfirst(strtolower($discussion['first_name'])) ?>
                    <?= ucfirst(strtolower($discussion['last_name'])) ?>
                </p>
            </div>

            <?php
            $posts_sql = "SELECT posts.*, users.first_name, users.last_name
                      FROM posts
                      JOIN users ON posts.user_id = users.id
                      WHERE posts.discussion_id = $discussionId
                      ORDER BY posts.created_at ASC";

            $posts_result = $conn->query($posts_sql);
            ?>

            <div class="posts">

                <?php while ($post = $posts_result->fetch_assoc()): ?>
                    <article>
                        <p> <?= htmlspecialchars($post['content']) ?>
                        </p>
                        <p><?= htmlspecialchars($post['created_at']) ?>
                        </p>
                        <p><?= ucfirst(strtolower($post['first_name'])) ?>
                            <?= ucfirst(strtolower($post['last_name'])) ?>
                        </p>
                    </article>
                <?php endwhile; ?>
            </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form class="reply-form" method="POST" action="reply.php">
                <div class="form-row">
                    <textarea name="content" required></textarea>
                    <input
                        type="hidden"
                        name="discussion_id"
                        value="<?= $discussionId ?>">
                </div>
                <div class="form-row">
                    <button class="reply-button" type="submit">
                        Reply
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </main>

    <?php require "includes/footer.php"; ?>

</body>

</html>
<?php
session_start();
require "includes/database.php";
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

<?php require "includes/menu.php";

$groupId = $_GET['id'];

$sql = "SELECT * FROM `groups` WHERE id = $groupId";
$result = $conn->query($sql);
$group = $result->fetch_assoc();
?>

<body>
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
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
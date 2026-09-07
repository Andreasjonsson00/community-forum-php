<?php
session_start();
require "includes/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$groupId = $_GET['group_id'] ?? $_POST['group_id'] ?? null;

if (!$groupId) {
    die("No group ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user_id'];
    $subject = trim($_POST['subject']);
    $content = trim($_POST['content']);

    if (empty($subject) || empty($content)) {
        echo "<p>Subject and content are required.</p>";
        exit;
    }

    $sql = "INSERT INTO discussions 
            (user_id, group_id, subject, content, created_at)
            VALUES ('$userId', '$groupId', '$subject', '$content', NOW())";

    if ($conn->query($sql)) {
        header("Location: group.php?id=$groupId");
        exit;
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Discussion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php require "includes/menu.php"; ?>
    <main>
        <h1>New Discussion</h1>
        <form class="create-discussion-form" action="create-discussion.php" method="POST">
            <input type="hidden" name="group_id" value="<?= $groupId ?>">
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
    </main>
    <?php require "includes/footer.php"; ?>

</body>

</html>
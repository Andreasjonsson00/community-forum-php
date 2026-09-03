<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<?php require 'includes/menu.php'; ?>

<body>
    <main>
        <h1 class="title">Create group</h1>
        <form action="store-group.php" method="POST">
            <div class="form-row">
                <label for="name">Group name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <br><br>

            <div class="form-row">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="create-group-button">
                <button type="submit">Create group</button>
            </div>
        </form>
    </main>
    <?php require 'includes/footer.php'; ?>
</body>

</html>
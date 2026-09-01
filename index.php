<?php session_start(); ?>
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
    <?php require "menu.php"; ?>

    <main>
        <h1>Welcome to the Community Forum</h1>
        <p>This is the main content of the page.</p>
        <?php require "groups.php"; ?>
        <?php $groups = get_Groups();
        foreach ($groups as $group) {
            echo "<p>" . $group['name'] . " - " . $group['description'] . "</p>";
        }
        ?>
    </main>
    <?php require "footer.php"; ?>
</body>

</html>
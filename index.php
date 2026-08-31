<?php
    $page_name = "Titel";
    echo "<h1>" . $page_name . "</h1>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>" . $page_name . "</title>"; ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require "menu.php"; ?>
    <?php require "groups.php"; ?>
    <?php $groups = get_Groups();
    foreach ($groups as $group) {
        echo "<p>" . $group['name'] . " - " . $group['description'] . "</p>";
    }
    ?>
</body>
</html>
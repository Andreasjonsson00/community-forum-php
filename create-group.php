<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php
    require 'includes/menu.php';
    ?>
    <h1>Create group</h1>
    <form action="store-group.php" method="POST">
        <label for="name">Group name:</label>
        <input type="text" id="name" name="name" required>

        <br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit">Create group</button>
    </form>

    <?php
    require 'includes/footer.php';
    ?>
</body>

</html>
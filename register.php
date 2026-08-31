<?php
$page_name = "Titel";
echo "<h1>" . $page_name . "</h1>";
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo "<p>Formuläret skickades!</p>";
}

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa konto</title>
</head>

<body>

    <?php require "menu.php"; ?>

    <h1>Skapa konto</h1>

    <form method="POST" action="register.php">

        <label for="first_name">Förnamn:</label>
        <input type="text" id="first_name" name="first_name" required>

        <br><br>

        <label for="last_name">Efternamn:</label>
        <input type="text" id="last_name" name="last_name" required>

        <br><br>

        <label for="email">E-post:</label>
        <input type="email" id="email" name="email" required>

        <br><br>

        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">Skapa konto</button>

    </form>

</body>

</html>
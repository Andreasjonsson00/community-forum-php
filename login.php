<?php
require "database.php";
session_start();
$page_name = "Titel";
echo "<h1>" . $page_name . "</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];

            echo "Du är inloggad!";
        } else {

            echo "Fel lösenord.";
        }
    } else {

        echo "Användaren finns inte.";
    }
}

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Logga in</title>
</head>

<body>
    <?php require "menu.php"; ?>
    <h1>Logga in</h1>

    <form method="POST" action="login.php">
        <label for="email">E-post:</label>
        <input type="email" id="email" name="email" required>

        <br><br>

        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">Logga in</button>
    </form>

</body>

</html>
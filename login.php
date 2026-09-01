<?php
require "database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];

            header("Location: index.php");
            exit;
        } else {

            echo "Fel lösenord.";
        }
    } else {

        echo "Användaren finns inte.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php require "menu.php"; ?>

    <main>
        <h1 class="title">Login</h1>
        <form method="POST" action="login.php">
            <div class="form-row">
                <label for="email">E-post:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <br><br>
            <div class="form-row">
                <label for="password">Lösenord:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br><br>
            <div class="form-row">
                <button type="submit">Logga in</button>
            </div>
        </form>
    </main>
    <?php require "footer.php"; ?>
</body>

</html>
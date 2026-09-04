<?php
require "includes/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Ogiltig e-postadress.</p>";
        exit;
    }

    $sql = "INSERT INTO users (first_name, last_name, email, password)
            VALUES ('$firstName', '$lastName', '$email', '$hash')";

    if ($conn->query($sql)) {
        header("Location: login.php");
        exit;
    } else {
        echo "<p>Fel: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<?php require "includes/menu.php"; ?>

<body>
    <main>
        <h1 class="title">Create Account</h1>
        <form method="POST" action="register.php">
            <div class="form-row">
                <label for="first_name">Förnamn:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <br><br>

            <div class="form-row">
                <label for="last_name">Efternamn:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <br><br>

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
                <button type="submit">Skapa konto</button>
            </div>
        </form>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
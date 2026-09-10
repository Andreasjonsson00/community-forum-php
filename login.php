<?php
session_start();
require "includes/database.php";

$error = null;
$success = null;
if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
    $success = "Account has been created. Please log in.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
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
    <?php require "includes/menu.php"; ?>
    <main>
        <h1 class="title">Login</h1>
        <form method="POST" action="login.php">
            <?php if ($success): ?>
                <p><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="form-row">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-row">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-row">
                <button type="submit">Login</button>
            </div>
        </form>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>
<header>
    <a href="index.php" class="logo">Community Forum</a>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="create-group.php">Create new Group</a></li>
                <li>Logged in</li>
                <li><a href="logout.php">Log out</a></li>
            <?php else: ?>
                <li><a href="login.php">Log in</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<?php
require 'includes/database.php';

$sql = "SELECT * FROM `groups`";
$result = $conn->query($sql);
?>

<?php while ($group = $result->fetch_assoc()): ?>
    <h2 class="group-name">
        <a href="group.php?id=<?= $group['id'] ?>">
            <?= htmlspecialchars($group['name']) ?>
        </a>
    </h2>

    <p class="description">
        <?= htmlspecialchars($group['description']) ?>
    </p>

    <?php if (isset($_SESSION['user_id'])): ?>

        <?php
        $user_id = $_SESSION['user_id'];
        $group_id = $group['id'];

        $member_sql = "SELECT * FROM user_groups
                       WHERE user_id = $user_id
                       AND group_id = $group_id";

        $member_result = $conn->query($member_sql);
        ?>

        <?php if ($member_result->num_rows > 0): ?>

            <form action="leave-group.php" method="POST">
                <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                <button type="submit">Leave Group</button>
            </form>

        <?php else: ?>

            <form action="join-group.php" method="POST">
                <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                <button type="submit">Join</button>
            </form>

        <?php endif; ?>

    <?php else: ?>

        <form action="register.php" method="GET">
            <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
            <button type="submit">Register to Join</button>
        </form>

    <?php endif; ?>

<?php endwhile; ?>
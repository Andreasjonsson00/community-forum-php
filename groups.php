<?php
require 'includes/database.php';

$stmt = $conn->prepare("SELECT * FROM `groups`");
$stmt->execute();
$result = $stmt->get_result();
?>


<?php while ($group = $result->fetch_assoc()): ?>

    <?php
    $canAccessGroup = false;

    if (isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];
        $group_id = $group['id'];

        $access_stmt = $conn->prepare("SELECT * FROM user_groups WHERE user_id = ? AND group_id = ?");
        $access_stmt->bind_param("ii", $user_id, $group_id);
        $access_stmt->execute();
        $access_result = $access_stmt->get_result();
        $canAccessGroup = $access_result->num_rows > 0;
    }

    ?>

    <div class="group-header">
        <h2 class="group-name">
            <?php if ($canAccessGroup): ?>
                <a href="group.php?id=<?= $group['id'] ?>">
                    <?= htmlspecialchars($group['name']) ?>
                </a>
            <?php else: ?>
                <?= htmlspecialchars($group['name']) ?>
            <?php endif; ?>
        </h2>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
            $user_id = $_SESSION['user_id'];
            $group_id = $group['id'];
            $member_stmt = $conn->prepare("SELECT * FROM user_groups WHERE user_id = ? AND group_id = ?");
            $member_stmt->bind_param("ii", $user_id, $group_id);
            $member_stmt->execute();
            $member_result = $member_stmt->get_result();
            ?>

            <?php if ($member_result->num_rows > 0): ?>
                <form action="leave-group.php" method="POST">
                    <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                    <button class="leave-group-button" type="submit">Leave Group</button>
                </form>

            <?php else: ?>
                <form action="apply-group.php" method="POST">
                    <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                    <button type="submit">Apply to Join</button>
                </form>
            <?php endif; ?>

        <?php else: ?>
            <form action="register.php" method="GET">
                <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                <button type="submit">Register to Join</button>
            </form>
        <?php endif; ?>

    </div>
    <p class="description">
        <?= htmlspecialchars($group['description']) ?>
    </p>

<?php endwhile; ?>
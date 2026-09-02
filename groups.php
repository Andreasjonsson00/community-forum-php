<?php
require 'includes/database.php';

$sql = "SELECT * FROM `groups`";
$result = $conn->query($sql);
?>

<?php while ($group = $result->fetch_assoc()): ?>
    <h2 class="group-name"><?= htmlspecialchars($group['name']) ?></h2>
    <p class="description"><?= htmlspecialchars($group['description']) ?></p>

    <form action="join-group.php" method="POST">
        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
        <button type="submit">Join</button>
    </form>

<?php endwhile; ?>
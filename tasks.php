<?php
// tasks.php
//require_once 'includes/db_connect.php';
require_once 'functions.php';
$pdo = db_conn();

check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $stmt = $pdo->prepare("INSERT INTO next_actions (id, action, status) VALUES (?, ?, 'active')");
    $stmt->execute([$_SESSION['id'], $action]);
}

include 'header.php';
?>

<h1>ネクストアクション</h1>

<form method="POST" action="">
    <input type="text" name="action" placeholder="新しいアクションを追加..." required>
    <button type="submit">追加</button>
</form>

<ul id="task-list">
    <?php
    $stmt = $pdo->prepare("SELECT * FROM next_actions WHERE id = ? AND status = 'active' ORDER BY created_at ASC");
    $stmt->execute([$_SESSION['id']]);
    $tasks = $stmt->fetchAll();
    foreach ($tasks as $task):
    ?>
        <li>
            <?php echo htmlspecialchars($task['action']); ?>
            <form method="POST" action="complete_action.php" style="display: inline;">
                <input type="hidden" name="action_id" value="<?php echo $task['id']; ?>">
                <button type="submit"><a href="complete_action.php">完了</a></button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'footer.php'; ?>
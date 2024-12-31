<?php
// dashboard.php
//require_once 'db_connect.php';
session_start();
require_once 'functions.php';

check_login();

/*// ユーザー情報取得
$user_id = $_SESSION['id']; // セッションからユーザーIDを取得
$user = get_user_info($pdo, $_SESSION['id']);*/

include 'header.php';


if (!isset($_SESSION['id'])) {
    // ログインしていない場合はリダイレクト
    header('Location: index.php');
    exit();
}

// DB接続
require_once('functions.php');
$pdo = db_conn();

// ユーザー情報を取得
//$email   = $_POST["email"];
//$name   = $_POST["name"];
$user_id = $_SESSION['id'];
$user_info = get_user_info($pdo, $user_id);

if (!$user_info) {
    echo "ユーザー情報が見つかりません。";
    exit();
}

//$name = $_SESSION['name'];
//$user_info = get_user_info($pdo, $name);

// ログイン処理
//$email = $_SESSION["email"];
$stmt = $pdo->prepare("SELECT id, password FROM user WHERE id = :id");
$stmt->bindValue(':id', $user_id, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<h1>ダッシュボード</h1>
<!--<p>こんにちは、/*<?php echo htmlspecialchars($user_info['id']); ?>*/さん！</p>-->
<p>こんにちは、<?php echo htmlspecialchars($user_info['name']); ?>さん！</p>

<div class="chat-section">
    <h2>今日はチャット日です</h2>
    <p>カウンセラーとチャットしましょう</p>
    <a href="chat.php" class="button">チャットを開始</a>
</div>

<div class="next-chat">
    <h2>次のチャット日は 1月2日木曜日 です</h2>
    <p>その間、ネクストアクションに取り組みましょう</p>
</div>

<div class="next-actions">
    <h2>ネクストアクション</h2>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM next_actions WHERE id = ? AND status = 'active' ORDER BY created_at ASC LIMIT 1");
    $stmt->execute([$_SESSION['id']]);
    $action = $stmt->fetch();
    if ($action): ?>
        <p><?php echo htmlspecialchars($action['action']); ?></p>
        <form method="post" action="complete_action.php">
            <input type="hidden" name="id" value="<?php echo $action['id']; ?>">
            <button type="submit">完了</button>
        </form>
    <?php else: ?>
        <p>現在のネクストアクションはありません。</p>
    <?php endif; ?>
    <a href="tasks.php" class="button">すべてのタスクを見る</a>
</div>

<?php include 'footer.php'; ?>
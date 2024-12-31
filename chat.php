<?php
// chat.php
session_start();
require_once 'functions.php';

// DB接続
$pdo = db_conn();

check_login();

// Dify API設定
require_once 'api.php';

function sendToDify($message) {
    global $dify_api_key, $dify_api_url;
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $dify_api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(['messages' => [['role' => 'user', 'content' => $message]]]),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $dify_api_key,
            'Content-Type: application/json'
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "Error: " . $err;
    } else {
        $result = json_decode($response, true);
        return $result['answer'] ?? "No response from Dify";
    }
}

// AJAXリクエストの処理
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');

    $message = $_POST['message'] ?? '';
    $user_id = $_SESSION['user_id'] ?? 0;

    if (empty($message)) {
        echo json_encode(['error' => 'メッセージを入力してください。']);
        exit;
    }

    // トランザクション開始
    $pdo->beginTransaction();

    try {
        // ユーザーメッセージをデータベースに保存
        $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, content, user) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $message]);

        // Difyにメッセージを送信し、応答を取得
        $bot_response = sendToDify($message);

        // ボットの応答をデータベースに保存
        $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, content, user) VALUES (?, ?, 0)");
        $stmt->execute([$user_id, $bot_response]);

        // トランザクションのコミット
        $pdo->commit();

        echo json_encode(['response' => $bot_response]);
    } catch (Exception $e) {
        // エラーが発生した場合はロールバック
        $pdo->rollBack();
        echo json_encode(['error' => 'エラーが発生しました。もう一度試してください。']);
    }

    exit;
}



include 'header.php';
?>

<h1>カウンセリングチャット</h1>

<div id="chat-messages">
    <?php
    $user_id = $_SESSION['user_id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM chat_messages WHERE user_id = ? ORDER BY created_at ASC");
    $stmt->execute([$user_id]);
    $messages = $stmt->fetchAll();
    foreach ($messages as $message):
    ?>
        <div class="message <?php echo $message['user'] ? 'user' : 'bot'; ?>">
            <?php echo htmlspecialchars($message['content']); ?>
        </div>
    <?php endforeach; ?>
</div>

<form id="chat-form" method="post">
    <input type="text" name="message" id="chat-input" placeholder="メッセージを入力..." required>
    <button type="submit">送信</button>
</form>

<script>
// JavaScriptコードはそのまま
</script>

<?php include 'footer.php'; ?>

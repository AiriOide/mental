<?php
// complete_action.php
//require_once 'includes/db_connect.php';
require_once 'functions.php';
$pdo = db_conn(); 

// セッションの確認とユーザー認証
check_login();

// POSTリクエストの確認
/*if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: tasks.php');
    exit();
}*/

// action_idの取得と検証
$action_id = isset($_POST['action_id']) ? intval($_POST['action_id']) : 0;
/*if ($action_id <= 0) {
    $_SESSION['error'] = 'Invalid action ID.';
    header('Location: tasks.php');
    exit();
}*/

try {
    // トランザクション開始
    $pdo->beginTransaction();

    // タスクの存在確認と所有者の検証
    $stmt = $pdo->prepare("SELECT * FROM next_actions WHERE id = ? AND id = ? AND status = 'active'");
    $stmt->execute([$action_id, $_SESSION['id']]);
    $task = $stmt->fetch();

    if (!$task) {
        throw new Exception('Task not found or already completed.');
    }

    // タスクのステータス更新
    $stmt = $pdo->prepare("UPDATE next_actions SET status = 'completed', completed_at = NOW() WHERE id = ?");
    $stmt->execute([$action_id]);

    // トランザクションのコミット
    $pdo->commit();

    $_SESSION['success'] = 'Task completed successfully.';
} catch (Exception $e) {
    // エラー発生時はロールバック
    $pdo->rollBack();
    $_SESSION['error'] = 'Error completing task: ' . $e->getMessage();
}

// タスクページにリダイレクト
/*header('Location: tasks.php');
exit();*/
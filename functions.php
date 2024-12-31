<?php
// mental/functions.php

// セッションの開始（セッションがまだ開始されていない場合のみ開始）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ログイン状態の確認
if (!function_exists('check_login')) {
    function check_login() {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php');
            exit();
        }
    }
}

// DB接続
function db_conn() {
    try {
        $db_name = "mental";    // データベース名
        $db_id   = "root";      // アカウント名
        $db_pw   = "";          // パスワード：XAMPPはパスワード無し
        $db_host = "localhost"; // DBホスト
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

// XSS対応
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

// リダイレクト
if (!function_exists('redirect')) {
    function redirect($file_name) {
        header("Location: ".$file_name);
        exit();
    }
}

// ユーザー情報を取得
if (!function_exists('get_user_info')) {
    function get_user_info($pdo, $id) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}

// メッセージ挿入時の重複確認
function insert_chat_message($pdo, $email, $content, $user_flag) {
    try {
        // 重複チェック
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM chat_messages WHERE email = :email AND content = :content");
        $stmt_check->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_check->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            return "Duplicate entry detected: The same message already exists.";
        }

        // 挿入処理
        $stmt = $pdo->prepare("INSERT INTO chat_messages (email, content, user) VALUES (:email, :content, :user)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':user', $user_flag, PDO::PARAM_INT);
        $stmt->execute();
        return "Message inserted successfully.";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return "Error inserting message.";
    }
}
?>

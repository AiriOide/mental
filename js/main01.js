// main.js

// チャットメッセージの送信
document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.querySelector("form");
    const chatInput = document.querySelector("input[name='message']");
    const chatMessages = document.getElementById("chat-messages");

    // フォーム送信時の処理
    chatForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // ページリロードを防ぐ

        const message = chatInput.value.trim();
        if (message === "") return;

        // ユーザーメッセージを画面に表示
        addMessageToChat(message, "user");

        try {
            // サーバーにメッセージを送信
            const response = await fetch("chat.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `message=${encodeURIComponent(message)}`,
            });

            const data = await response.text();
            if (response.ok) {
                // サーバーからの応答を表示
                addMessageToChat(data, "bot");
            } else {
                addMessageToChat("エラーが発生しました。", "bot");
            }
        } catch (error) {
            console.error("Error:", error);
            addMessageToChat("通信エラーが発生しました。", "bot");
        }

        chatInput.value = ""; // 入力をクリア
    });

    // チャットにメッセージを追加する関数
    function addMessageToChat(message, userType) {
        const messageElement = document.createElement("div");
        messageElement.className = `message ${userType}`;
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight; // 自動スクロール
    }
});

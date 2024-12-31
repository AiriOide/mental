// main.js

document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const chatMessages = document.getElementById("chat-messages");

    chatForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        const message = chatInput.value.trim();
        if (message === "") return;

        addMessageToChat(message, "user");

        try {
            const response = await fetch("chat.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `ajax=1&message=${encodeURIComponent(message)}`,
            });

            const data = await response.json();
            if (data.response) {
                addMessageToChat(data.response, "bot");
            } else if (data.error) {
                addMessageToChat(data.error, "bot");
            }
        } catch (error) {
            console.error("Error:", error);
            addMessageToChat("通信エラーが発生しました。", "bot");
        }

        chatInput.value = "";
    });

    function addMessageToChat(message, userType) {
        const messageElement = document.createElement("div");
        messageElement.className = `message ${userType}`;
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
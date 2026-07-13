const sendBtn = document.getElementById("sendBtn");
const input = document.getElementById("userInput");
const body = document.getElementById("chat-body");
const toggle = document.getElementById("chat-toggle");
const closeBtn = document.getElementById("close-chat");
const chatBox = document.getElementById("chat-box");

let isLoading = false;

if (toggle) {
    toggle.addEventListener("click", openChat);
    toggle.addEventListener("keypress", e => {
        if (e.key === "Enter") openChat();
    });
}

if (closeBtn) {
    closeBtn.addEventListener("click", closeChat);
}

if (sendBtn) {
    sendBtn.addEventListener("click", sendMessage);
}

if (input) {
    input.addEventListener("keypress", e => {
        if (e.key === "Enter") {
            sendMessage();
        }
    });
}

function openChat() {
    if (!chatBox) return;
    chatBox.classList.remove("chat-hidden");
    chatBox.setAttribute("aria-hidden", "false");
    input?.focus();
}

function closeChat() {
    if (!chatBox) return;
    chatBox.classList.add("chat-hidden");
    chatBox.setAttribute("aria-hidden", "true");
}

function appendMessage(text, role) {
    if (!body) return;
    const messageEl = document.createElement("div");
    messageEl.className = role === "user" ? "user" : "bot";
    messageEl.textContent = text;
    body.appendChild(messageEl);
    body.scrollTop = body.scrollHeight;
    return messageEl;
}

async function sendMessage() {
    if (!input || !body || !sendBtn || isLoading) return;

    const message = input.value.trim();
    if (message === "") return;

    appendMessage(message, "user");
    input.value = "";
    input.focus();

    const loadingEl = appendMessage("Typing...", "bot");
    loadingEl.classList.add("loading");
    setLoading(true);

    try {
        const response = await fetch("backend/chat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ message })
        });

        const data = await response.json();
        const reply = data.reply || "Sorry, something went wrong. Please try again.";
        loadingEl.textContent = reply;
        loadingEl.classList.remove("loading");
    } catch (error) {
        loadingEl.textContent = "Chat service unavailable. Please try again later.";
        loadingEl.classList.remove("loading");
        console.error(error);
    }

    setLoading(false);
}

function setLoading(state) {
    isLoading = state;
    if (sendBtn) sendBtn.disabled = state;
    if (input) input.disabled = state;
}

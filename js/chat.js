let sendBtn;
let input;
let body;
let toggle;
let closeBtn;
let chatBox;

let isLoading = false;

const messages = [
    {
        role: "system",
        content:
            "You are the AI assistant for Paruchuru Chanikya's portfolio. Answer questions about his skills, projects, certifications, education, and contact details in a friendly and professional tone."
    }
];

const maxHistoryMessages = 12;

function initChat() {
    sendBtn = document.getElementById("sendBtn");
    input = document.getElementById("userInput");
    body = document.getElementById("chat-body");
    toggle = document.getElementById("chat-toggle");
    closeBtn = document.getElementById("close-chat");
    chatBox = document.getElementById("chat-box");

    if (toggle) {
        toggle.addEventListener("click", openChat);
        toggle.addEventListener("keydown", e => {
            if (e.key === "Enter" || e.key === " ") openChat();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", closeChat);
    }

    if (sendBtn) {
        sendBtn.addEventListener("click", sendMessage);
    }

    if (input) {
        input.addEventListener("keydown", e => {
            if (e.key === "Enter") {
                sendMessage();
            }
        });
    }

    if (chatBox && chatBox.classList.contains("chat-hidden")) {
        chatBox.style.display = "none";
    }
}

window.addEventListener("DOMContentLoaded", initChat);
window.addEventListener("load", initChat);

function openChat() {
    if (!chatBox) return;
    chatBox.classList.remove("chat-hidden");
    chatBox.style.display = "flex";
    chatBox.setAttribute("aria-hidden", "false");
    input?.focus();
}

function closeChat() {
    if (!chatBox) return;
    chatBox.classList.add("chat-hidden");
    chatBox.style.display = "none";
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

    messages.push({ role: "user", content: message });
    appendMessage(message, "user");

    input.value = "";
    input.focus();

    const loadingEl = appendMessage("Typing...", "bot");
    loadingEl.classList.add("loading");
    setLoading(true);

    try {
        const payload = {
            messages: messages.slice(
                Math.max(0, messages.length - maxHistoryMessages - 1)
            )
        };

        const response = await fetch("backend/chat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        const reply = data.reply || "Sorry, something went wrong. Please try again.";

        messages.push({ role: "assistant", content: reply });
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

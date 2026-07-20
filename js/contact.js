// ================================
// Contact Form -> Backend API
// ================================

const contactForm = document.getElementById("contact-form");
const status = document.getElementById("status");

// Field id mapping: the PHP backend expects name, email, subject, message
const FIELD_MAP = {
    from_name: "name",
    from_email: "email",
    subject: "subject",
    message: "message"
};

if (contactForm) {
    contactForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        status.innerHTML = "⏳ Sending...";
        status.style.color = "#38bdf8";

        const raw = new FormData(contactForm);
        const payload = {};
        raw.forEach((value, key) => {
            const mapped = FIELD_MAP[key] || key;
            payload[mapped] = value;
        });

        try {
            const response = await fetch("backend/api/contact.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            let data = {};
            try {
                data = await response.json();
            } catch (_) {}

            if (response.ok && data.success) {
                status.innerHTML = "✅ " + (data.message || "Message Sent Successfully!");
                status.style.color = "#22c55e";
                contactForm.reset();
            } else {
                status.innerHTML = "❌ " + (data.message || "Failed to send message!");
                status.style.color = "#ef4444";
            }
        } catch (error) {
            console.error(error);
            status.innerHTML = "❌ Could not reach the server. Please try again.";
            status.style.color = "#ef4444";
        }
    });
}

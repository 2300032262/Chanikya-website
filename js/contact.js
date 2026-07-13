// ================================
// EmailJS Contact Form
// ================================

// Replace with your EmailJS Public Key
emailjs.init({
    publicKey: "YOUR_PUBLIC_KEY"
});

const contactForm = document.getElementById("contact-form");
const status = document.getElementById("status");

contactForm.addEventListener("submit", function (e) {

    e.preventDefault();

    status.innerHTML = "⏳ Sending...";
    status.style.color = "#38bdf8";

    emailjs.sendForm(
        "YOUR_SERVICE_ID",
        "YOUR_TEMPLATE_ID",
        this
    )
    .then(() => {

        status.innerHTML = "✅ Message Sent Successfully!";
        status.style.color = "#22c55e";

        contactForm.reset();

    })
    .catch((error) => {

        console.log(error);

        status.innerHTML = "❌ Failed to send message!";
        status.style.color = "#ef4444";

    });

});
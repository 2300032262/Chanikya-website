/*
=========================================
Typing Animation
=========================================
*/

const roles = [
    "Full Stack Developer",
    "Java Developer",
    "Frontend Developer",
    "Backend Developer",
    "Web Designer",
    "UI/UX Designer",
    "Software Engineer",
    "Open Source Learner"
];

let roleIndex = 0;
let charIndex = 0;
let deleting = false;

const typingElement = document.getElementById("typing");

function typeEffect() {

    if (!typingElement) return;

    const currentRole = roles[roleIndex];

    if (!deleting) {

        typingElement.textContent =
            currentRole.substring(0, charIndex);

        charIndex++;

        if (charIndex > currentRole.length) {

            deleting = true;

            setTimeout(typeEffect, 1500);

            return;

        }

    } else {

        typingElement.textContent =
            currentRole.substring(0, charIndex);

        charIndex--;

        if (charIndex < 0) {

            deleting = false;

            roleIndex++;

            if (roleIndex >= roles.length) {

                roleIndex = 0;

            }

        }

    }

    setTimeout(typeEffect, deleting ? 50 : 100);

}

window.onload = typeEffect;



















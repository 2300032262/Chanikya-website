// ===============================
// Personal Portfolio JavaScript
// ===============================

document.addEventListener("DOMContentLoaded", () => {

    console.log("Portfolio Loaded Successfully");

    // ===============================
    // Navbar Effect
    // ===============================

    const navbar = document.querySelector("header");

    if(navbar){

        window.addEventListener("scroll", () => {

            if(window.scrollY > 80){

                navbar.style.background = "#020617";
                navbar.style.boxShadow = "0 5px 20px rgba(0,0,0,.4)";

            }else{

                navbar.style.background = "rgba(15,23,42,.9)";
                navbar.style.boxShadow = "none";

            }

        });

    }

});


// ===============================
// Smooth Scroll
// ===============================

document.querySelectorAll('a[href^="#"]').forEach(link=>{

    link.addEventListener("click",function(e){

        const href=this.getAttribute("href");

        if(href==="#") return;

        const target=document.querySelector(href);

        if(target){

            e.preventDefault();

            target.scrollIntoView({

                behavior:"smooth"

            });

        }

    });

});


// ===============================
// Scroll Progress Bar
// ===============================

const progress=document.createElement("div");

progress.id="progress-bar";

document.body.appendChild(progress);

window.addEventListener("scroll",()=>{

    const totalHeight=document.documentElement.scrollHeight-document.documentElement.clientHeight;

    const progressHeight=(window.pageYOffset/totalHeight)*100;

    progress.style.width=progressHeight+"%";

});


// ===============================
// Back To Top Button
// ===============================

const topBtn=document.createElement("button");

topBtn.innerHTML="↑";

topBtn.id="topBtn";

document.body.appendChild(topBtn);

topBtn.onclick=()=>{

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

};

window.addEventListener("scroll",()=>{

    if(window.scrollY>400){

        topBtn.style.display="block";

    }else{

        topBtn.style.display="none";

    }

});


// ===============================
// Typing Animation
// ===============================

const typingElement=document.querySelector(".hero-left h2");

if(typingElement){

    const titles=[

        "Full Stack Developer",
        "Java Developer",
        "Frontend Developer",
        "Web Designer"

    ];

    let count=0;

    let index=0;

    let currentText="";

    let letter="";

    (function type(){

        if(count===titles.length){

            count=0;

        }

        currentText=titles[count];

        letter=currentText.slice(0,++index);

        typingElement.textContent=letter;

        if(letter.length===currentText.length){

            count++;

            index=0;

            setTimeout(type,1500);

        }else{

            setTimeout(type,120);

        }

    })();

}


// ===============================
// Reveal Animation
// ===============================

// Skip login page
const reveals=document.querySelectorAll("section:not(.login-section)");

function revealSections(){

    reveals.forEach(section=>{

        const windowHeight=window.innerHeight;

        const revealTop=section.getBoundingClientRect().top;

        const revealPoint=120;

        if(revealTop<windowHeight-revealPoint){

            section.classList.add("active");

        }

    });

}

window.addEventListener("scroll",revealSections);

revealSections();


// ===============================
// Counter Animation
// ===============================

const counters=document.querySelectorAll(".counter");

counters.forEach(counter=>{

    counter.innerText="0";

    const updateCounter=()=>{

        const target=+counter.getAttribute("data-target");

        const current=+counter.innerText;

        const increment=target/100;

        if(current<target){

            counter.innerText=Math.ceil(current+increment);

            setTimeout(updateCounter,20);

        }else{

            counter.innerText=target;

        }

    }

    updateCounter();

});


// ===============================
// Footer Year
// ===============================

const footer=document.querySelector("footer p");

if(footer){

    footer.innerHTML=`© ${new Date().getFullYear()} Paruchuru Chanikya | All Rights Reserved`;

}
/*
====================================
PORTFOLIO THEME SWITCHER
Dark / Light Mode
====================================
*/


// Select Theme Button

const themeButton = document.querySelector("#theme-toggle");



// Check Saved Theme

let savedTheme = localStorage.getItem("theme");



if(savedTheme === "light"){

    document.body.classList.add("light-mode");

}



// Button Click

if(themeButton){


themeButton.addEventListener("click",()=>{


    document.body.classList.toggle("light-mode");



    if(document.body.classList.contains("light-mode")){


        localStorage.setItem(

            "theme",

            "light"

        );


    }

    else{


        localStorage.setItem(

            "theme",

            "dark"

        );


    }



});


}














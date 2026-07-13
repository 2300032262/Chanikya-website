const sendBtn=document.getElementById("sendBtn");
const input=document.getElementById("userInput");
const body=document.getElementById("chat-body");

sendBtn.onclick=sendMessage;

input.addEventListener("keypress",e=>{

if(e.key==="Enter"){

sendMessage();

}

});

async function sendMessage(){

const message=input.value.trim();

if(message==="") return;

body.innerHTML+=`<div class="user">${message}</div>`;

input.value="";

const response=await fetch("backend/chat.php",{

method:"POST",

headers:{

"Content-Type":"application/json"

},

body:JSON.stringify({

message

})

});

const data=await response.json();

body.innerHTML+=`<div class="bot">${data.reply}</div>`;

body.scrollTop=body.scrollHeight;

}
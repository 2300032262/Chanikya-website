<?php


require_once "../config/database.php";



if($_SERVER["REQUEST_METHOD"]=="POST"){



$name=$_POST["name"];

$email=$_POST["email"];

$subject=$_POST["subject"];

$message=$_POST["message"];





$sql="INSERT INTO contact_messages

(name,email,subject,message)

VALUES

(:name,:email,:subject,:message)";




$stmt=$conn->prepare($sql);



$stmt->execute([


":name"=>$name,

":email"=>$email,

":subject"=>$subject,

":message"=>$message


]);



echo "

<script>

alert('Message Sent Successfully');

window.location='../../contact.html';

</script>

";



}


?>













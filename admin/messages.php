<?php

session_start();


if(!isset($_SESSION["admin_id"])){

    header("Location: ../login.html");
    exit();

}


require_once "../backend/config/database.php";



// DELETE MESSAGE

if(isset($_GET["delete"])){

    $id=$_GET["delete"];


    $stmt=$conn->prepare(

        "DELETE FROM contact_messages WHERE id=:id"

    );


    $stmt->execute([

        ":id"=>$id

    ]);


    header("Location: messages.php");

}




// GET MESSAGES

$messages=$conn->query(

    "SELECT * FROM contact_messages ORDER BY id DESC"

)->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Messages</title>


<link rel="stylesheet" href="../css/style.css">

<link rel="stylesheet" href="../css/dashboard.css">


</head>


<body>



<div class="dashboard">



<!-- SIDEBAR -->


<aside class="sidebar">


<h2>

CHANIKYA

</h2>



<ul>


<li>

<a href="dashboard.php">

Dashboard

</a>

</li>


<li>

<a href="projects.php">

Projects

</a>

</li>


<li>

<a href="certificates.php">

Certificates

</a>

</li>


<li>

<a href="messages.php">

Messages

</a>

</li>


<li>

<a href="logout.php">

Logout

</a>

</li>


</ul>


</aside>





<!-- CONTENT -->


<main class="dashboard-content">



<h1>

Contact Messages

</h1>



<div class="dashboard-cards">



<?php foreach($messages as $message){ ?>



<div class="dashboard-card">



<h3>

<?= $message["name"]; ?>

</h3>



<p>

<strong>Email:</strong>

<?= $message["email"]; ?>

</p>



<p>

<strong>Subject:</strong>

<?= $message["subject"]; ?>

</p>



<p>

<?= $message["message"]; ?>

</p>



<br>


<a

class="btn"

href="?delete=<?= $message["id"]; ?>"

onclick="return confirm('Delete message?')">

Delete

</a>



</div>



<?php } ?>



</div>



</main>



</div>



</body>

</html>









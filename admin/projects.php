<?php

session_start();

if(!isset($_SESSION["admin_id"])){

    header("Location: ../login.html");
    exit();

}


require_once "../backend/config/database.php";


// ADD PROJECT

if(isset($_POST["add_project"])){

    $title = $_POST["title"];

    $description = $_POST["description"];

    $technology = $_POST["technology"];

    $github = $_POST["github"];

    $demo = $_POST["demo"];



    $sql = "INSERT INTO projects
    (title,description,technology,github,demo)

    VALUES
    (:title,:description,:technology,:github,:demo)";


    $stmt = $conn->prepare($sql);


    $stmt->execute([

        ":title"=>$title,

        ":description"=>$description,

        ":technology"=>$technology,

        ":github"=>$github,

        ":demo"=>$demo

    ]);


    header("Location: projects.php");

}


// DELETE PROJECT

if(isset($_GET["delete"])){

    $id=$_GET["delete"];


    $stmt=$conn->prepare(

        "DELETE FROM projects WHERE id=:id"

    );


    $stmt->execute([

        ":id"=>$id

    ]);


    header("Location: projects.php");

}



// GET PROJECTS

$projects=$conn->query(

    "SELECT * FROM projects ORDER BY id DESC"

)->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Manage Projects</title>


<link rel="stylesheet" href="../css/dashboard.css">

<link rel="stylesheet" href="../css/style.css">


</head>


<body>


<div class="dashboard">



<aside class="sidebar">


<h2>CHANIKYA</h2>


<ul>

<li>
<a href="dashboard.php">Dashboard</a>
</li>

<li>
<a href="projects.php">Projects</a>
</li>

<li>
<a href="certificates.php">Certificates</a>
</li>

<li>
<a href="messages.php">Messages</a>
</li>

<li>
<a href="logout.php">Logout</a>
</li>

</ul>


</aside>



<main class="dashboard-content">


<h1>

Manage Projects

</h1>



<!-- ADD PROJECT FORM -->


<div class="admin-form">


<form method="POST">


<input

type="text"

name="title"

placeholder="Project Title"

required>


<br><br>


<textarea

name="description"

placeholder="Project Description"

required></textarea>


<br><br>


<input

type="text"

name="technology"

placeholder="Technology Used"

required>


<br><br>


<input

type="text"

name="github"

placeholder="Github Link">


<br><br>


<input

type="text"

name="demo"

placeholder="Live Demo Link">


<br><br>


<button

class="btn"

name="add_project">

Add Project

</button>



</form>


</div>





<h2>

All Projects

</h2>



<div class="dashboard-cards">



<?php foreach($projects as $project){ ?>


<div class="dashboard-card">


<h3>

<?= $project["title"]; ?>

</h3>


<p>

<?= $project["technology"]; ?>

</p>



<a 

href="?delete=<?= $project["id"]; ?>"

class="btn"

onclick="return confirm('Delete this project?')">

Delete

</a>


</div>



<?php } ?>



</div>



</main>


</div>


</body>

</html>








<?php

session_start();


// Check Login

if(!isset($_SESSION["admin_id"])){

    header("Location: ../login.html");

    exit();

}


require_once "../backend/config/database.php";


// Count Projects

$projectQuery = $conn->query(
    "SELECT COUNT(*) FROM projects"
);

$totalProjects = $projectQuery->fetchColumn();


// Count Certificates

$certificateQuery = $conn->query(
    "SELECT COUNT(*) FROM certificates"
);

$totalCertificates = $certificateQuery->fetchColumn();


// Count Messages

$messageQuery = $conn->query(
    "SELECT COUNT(*) FROM contact_messages"
);

$totalMessages = $messageQuery->fetchColumn();


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Admin Dashboard</title>


<link rel="stylesheet" href="../css/style.css">

<link rel="stylesheet" href="../css/dashboard.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


</head>


<body>


<div class="dashboard">


<!-- Sidebar -->


<aside class="sidebar">


<h2>

CHANIKYA

</h2>


<ul>


<li>

<a href="dashboard.php">

<i class="fa fa-home"></i>

Dashboard

</a>

</li>


<li>

<a href="projects.php">

<i class="fa fa-folder"></i>

Projects

</a>

</li>


<li>

<a href="certificates.php">

<i class="fa fa-certificate"></i>

Certificates

</a>

</li>


<li>

<a href="messages.php">

<i class="fa fa-envelope"></i>

Messages

</a>

</li>


<li>

<a href="settings.php">

<i class="fa fa-gear"></i>

Settings

</a>

</li>


<li>

<a href="logout.php">

<i class="fa fa-sign-out"></i>

Logout

</a>

</li>


</ul>


</aside>



<!-- Main Content -->


<main class="dashboard-content">


<h1>

Welcome,

<?php echo $_SESSION["admin_name"]; ?>

👋

</h1>


<p>

Manage your portfolio website here.

</p>



<div class="dashboard-cards">


<div class="dashboard-card">


<i class="fa fa-folder"></i>


<h2>

<?php echo $totalProjects; ?>

</h2>


<p>

Projects

</p>


</div>




<div class="dashboard-card">


<i class="fa fa-certificate"></i>


<h2>

<?php echo $totalCertificates; ?>

</h2>


<p>

Certificates

</p>


</div>




<div class="dashboard-card">


<i class="fa fa-envelope"></i>


<h2>

<?php echo $totalMessages; ?>

</h2>


<p>

Messages

</p>


</div>



</div>


</main>



</div>



</body>

</html>







<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.html");
    exit();
}

require_once "../backend/config/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard">
<aside class="sidebar">
<h2>CHANIKYA</h2>
<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="projects.php">Projects</a></li>
<li><a href="certificates.php">Certificates</a></li>
<li><a href="messages.php">Messages</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</aside>
<main class="dashboard-content">
<h1>Settings</h1>
<p>Admin settings will be available here.</p>
</main>
</div>
</body>
</html>

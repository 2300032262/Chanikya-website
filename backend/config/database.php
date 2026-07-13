<?php

// ===============================
// DATABASE CONFIGURATION
// Personal Portfolio Website
// ===============================


// Database Server

$host = "localhost";


// Database Name

$dbname = "portfolio";


// Database Username

$username = "root";


// Database Password

$password = "";



try {


    // Create Database Connection

    $conn = new PDO(

        "mysql:host=$host;dbname=$dbname;charset=utf8",

        $username,

        $password

    );


    // Enable Error Mode

    $conn->setAttribute(

        PDO::ATTR_ERRMODE,

        PDO::ERRMODE_EXCEPTION

    );



}

catch(PDOException $e){


    die(

        "Database Connection Failed : "

        . $e->getMessage()

    );


}


?>




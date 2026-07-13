<?php

session_start();


if(!isset($_SESSION["admin_id"])){

    header("Location: ../login.html");
    exit();

}


require_once "../backend/config/database.php";



// ADD CERTIFICATE

if(isset($_POST["add_certificate"])){


    $title = $_POST["title"];

    $issuer = $_POST["issuer"];



    $image = "";


    // Image Upload

    if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]!=""){


        $image = time()."_".$_FILES["image"]["name"];


        move_uploaded_file(

            $_FILES["image"]["tmp_name"],

            "../backend/uploads/certificates/".$image

        );


    }



    $sql = "INSERT INTO certificates

    (title,issuer,certificate_image)

    VALUES

    (:title,:issuer,:image)";



    $stmt=$conn->prepare($sql);



    $stmt->execute([


        ":title"=>$title,

        ":issuer"=>$issuer,

        ":image"=>$image


    ]);



    header("Location: certificates.php");

}





// DELETE CERTIFICATE


if(isset($_GET["delete"])){


    $id=$_GET["delete"];


    $stmt=$conn->prepare(

        "DELETE FROM certificates WHERE id=:id"

    );


    $stmt->execute([

        ":id"=>$id

    ]);



    header("Location: certificates.php");


}




// GET CERTIFICATES


$certificates=$conn->query(

"SELECT * FROM certificates ORDER BY id DESC"

)->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Certificates</title>


<link rel="stylesheet" href="../css/style.css">

<link rel="stylesheet" href="../css/dashboard.css">


</head>



<body>



<div class="dashboard">


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





<main class="dashboard-content">



<h1>

Manage Certificates

</h1>




<div class="admin-form">


<form method="POST" enctype="multipart/form-data">


<input

type="text"

name="title"

placeholder="Certificate Title"

required>


<br><br>


<input

type="text"

name="issuer"

placeholder="Certificate Issuer"

required>


<br><br>



<input

type="file"

name="image">


<br><br>


<button

class="btn"

name="add_certificate">

Add Certificate

</button>


</form>


</div>





<h2>

All Certificates

</h2>



<div class="dashboard-cards">



<?php foreach($certificates as $certificate){ ?>



<div class="dashboard-card">


<h3>

<?= $certificate["title"]; ?>

</h3>


<p>

<?= $certificate["issuer"]; ?>

</p>



<?php if($certificate["certificate_image"]!=""){ ?>


<img

src="../backend/uploads/certificates/<?= $certificate["certificate_image"]; ?>"

width="150">


<?php } ?>



<br><br>


<a

class="btn"

href="?delete=<?= $certificate["id"]; ?>"

onclick="return confirm('Delete certificate?')">

Delete

</a>



</div>



<?php } ?>



</div>



</main>



</div>



</body>

</html>






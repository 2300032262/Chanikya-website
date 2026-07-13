<?php

session_start();

require_once "../config/database.php";


// Check Form Submit

if($_SERVER["REQUEST_METHOD"] == "POST"){


    $username = $_POST["username"];

    $password = $_POST["password"];



    try{


        // Find Admin User

        $query = "SELECT * FROM admin WHERE username = :username";


        $stmt = $conn->prepare($query);


        $stmt->bindParam(
            ":username",
            $username
        );


        $stmt->execute();



        $admin = $stmt->fetch(PDO::FETCH_ASSOC);



        if($admin){



            // Check Password

            if($password == $admin["password"]){



                $_SESSION["admin_id"] = $admin["id"];

                $_SESSION["admin_name"] = $admin["username"];



                header(
                    "Location: ../../admin/dashboard.php"
                );


                exit();



            }

            else{


                echo "

                <script>

                alert('Wrong Password');

                window.location='../../login.html';

                </script>

                ";

            }



        }

        else{


            echo "

            <script>

            alert('User Not Found');

            window.location='../../login.html';

            </script>

            ";


        }



    }

    catch(PDOException $e){


        echo "Error : ".$e->getMessage();


    }



}

?>







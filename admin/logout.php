<?php

session_start();


// Destroy Admin Session

session_unset();

session_destroy();


// Redirect To Login

header("Location: ../login.html");

exit();

?>




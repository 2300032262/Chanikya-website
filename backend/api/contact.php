<?php

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../contact.html");
    exit();
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $email === "" || $subject === "" || $message === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../contact.html");
    exit();
}

try {
    $sql = "INSERT INTO contact_messages (name,email,subject,message) VALUES (:name,:email,:subject,:message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":subject" => $subject,
        ":message" => $message
    ]);

    header("Location: ../../contact.html");
    exit();
} catch (PDOException $e) {
    error_log("Contact form error: " . $e->getMessage());
    header("Location: ../../contact.html");
    exit();
}
?>

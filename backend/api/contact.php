<?php

// CORS (adjust origin in production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

// Preflight
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
    exit();
}

// Support both JSON and form-encoded bodies
$input = json_decode(file_get_contents("php://input"), true);
if (!is_array($input)) {
    $input = $_POST;
}

$name = trim($input["name"] ?? "");
$email = trim($input["email"] ?? "");
$subject = trim($input["subject"] ?? "");
$message = trim($input["message"] ?? "");

if ($name === "" || $email === "" || $subject === "" || $message === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Please fill all fields with a valid email."]);
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

    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Message sent successfully!"]);
} catch (PDOException $e) {
    error_log("Contact form error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to save message. Please try again."]);
}

?>

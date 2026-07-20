<?php

session_start();
require_once "../config/database.php";

// Helper to respond either as JSON (AJAX/fetch) or via redirect (classic form post)
function finishLogin(bool $success, string $message, string $redirect)
{
    $isAjax = !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
        strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest" ||
        (isset($_SERVER["HTTP_ACCEPT"]) && strpos($_SERVER["HTTP_ACCEPT"], "application/json") !== false);

    if ($isAjax) {
        header("Content-Type: application/json; charset=utf-8");
        http_response_code($success ? 200 : 401);
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "redirect" => $success ? $redirect : null
        ]);
        exit();
    }

    header("Location: " . ($success ? $redirect : "../../login.html"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../login.html");
    exit();
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($username === "" || $password === "") {
    finishLogin(false, "Please enter both username and password.", "../../login.html");
}

try {
    $query = "SELECT * FROM admin WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$admin) {
        finishLogin(false, "Invalid username or password.", "../../login.html");
    }

    $passwordIsValid = false;
    $needsRehash = false;

    if (password_verify($password, $admin["password"])) {
        $passwordIsValid = true;
        if (password_needs_rehash($admin["password"], PASSWORD_DEFAULT)) {
            $needsRehash = true;
        }
    } elseif ($password === $admin["password"]) {
        // Legacy plaintext fallback (will be rehashed below)
        $passwordIsValid = true;
        $needsRehash = true;
    }

    if (!$passwordIsValid) {
        finishLogin(false, "Invalid username or password.", "../../login.html");
    }

    if ($needsRehash) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE admin SET password = :password WHERE id = :id");
        $updateStmt->execute([
            ":password" => $newHash,
            ":id" => $admin["id"],
        ]);
    }

    session_regenerate_id(true);
    $_SESSION["admin_id"] = $admin["id"];
    $_SESSION["admin_name"] = $admin["username"];

    finishLogin(true, "Login successful.", "../../admin/dashboard.php");
} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    finishLogin(false, "Something went wrong. Please try again.", "../../login.html");
}

?>

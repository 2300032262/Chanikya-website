<?php

session_start();
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../login.html");
    exit();
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($username === "" || $password === "") {
    header("Location: ../../login.html");
    exit();
}

try {
    $query = "SELECT * FROM admin WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$admin) {
        header("Location: ../../login.html");
        exit();
    }

    $passwordIsValid = false;
    $needsRehash = false;

    if (password_verify($password, $admin["password"])) {
        $passwordIsValid = true;
        if (password_needs_rehash($admin["password"], PASSWORD_DEFAULT)) {
            $needsRehash = true;
        }
    } elseif ($password === $admin["password"]) {
        $passwordIsValid = true;
        $needsRehash = true;
    }

    if (!$passwordIsValid) {
        header("Location: ../../login.html");
        exit();
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

    header("Location: ../../admin/dashboard.php");
    exit();
} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    header("Location: ../../login.html");
    exit();
}

?>

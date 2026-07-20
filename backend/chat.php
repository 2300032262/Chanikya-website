<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

// Preflight
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}

$API_KEY = getenv("OPENAI_API_KEY");
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    $data = [];
}

$messages = $data["messages"] ?? [];
$message = trim($data["message"] ?? "");

if (!is_array($messages) || count($messages) === 0) {
    if ($message !== "") {
        $messages = [
            [
                "role" => "system",
                "content" => "You are the AI assistant for Paruchuru Chanikya's portfolio. Answer questions about his skills, projects, certifications, education and contact details in a friendly and professional tone."
            ],
            [
                "role" => "user",
                "content" => $message
            ]
        ];
    }
}

if (empty($messages)) {
    http_response_code(400);
    echo json_encode(["reply" => "Please type a message."]);
    exit();
}

if ($API_KEY) {
    $reply = callOpenAI($API_KEY, $messages);
    if ($reply !== null) {
        echo json_encode(["reply" => $reply]);
        exit();
    }
    error_log("OpenAI call failed; using fallback mode.");
}

$latestUserMessage = "";
foreach ($messages as $msg) {
    if (isset($msg["role"], $msg["content"]) && $msg["role"] === "user") {
        $latestUserMessage = trim($msg["content"]);
    }
}

if ($latestUserMessage === "") {
    $latestUserMessage = $message;
}

echo json_encode(["reply" => offlineReply($latestUserMessage)]);

/**
 * Call OpenAI Chat Completions. Returns reply string or null on failure.
 */
function callOpenAI(string $apiKey, array $messages): ?string
{
    $postData = [
        "model" => "gpt-4.1-mini",
        "messages" => $messages
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($result === false || $error) {
        error_log("Chat API error: " . $error);
        return null;
    }

    $response = json_decode($result, true);
    return $response["choices"][0]["message"]["content"] ?? null;
}

/**
 * Offline assistant: answers portfolio questions without an external API.
 */
function offlineReply(string $message): string
{
    $q = strtolower($message);

    $faq = [
        "skills" => "Chanikya's skills include Java, HTML, CSS, JavaScript, PHP, MySQL, Python, React, Node.js and AWS Cloud. He is strongest in Java (90%) and frontend development.",
        "project" => "Some of his projects are an Inventory Management System, a Disaster Management System, a Gaming Hub, a Student ERP System and a Ticket Booking System — built with HTML, CSS, JavaScript, PHP and MySQL.",
        "certificate" => "He holds certifications in AWS Cloud Practitioner, Aviatrix Multicloud Network Associate, Oracle Foundations Associate, and Automation Anywhere RPA.",
        "education" => "Chanikya is a B.Tech Computer Science Engineering student based in Andhra Pradesh, India.",
        "contact" => "You can reach Chanikya at paruchuruchanikya550@gmail.com or call +91 9032084839. He is based in Andhra Pradesh, India.",
        "resume" => "You can download his resume from the Home page using the 'Download Resume' button, or use the contact form to get in touch.",
        "hire" => "Chanikya is open to internships and collaboration. Please use the contact page to send him a message!"
    ];

    foreach ($faq as $key => $answer) {
        if (strpos($q, $key) !== false) {
            return $answer;
        }
    }

    if (strpos($q, "hello") !== false || strpos($q, "hi") !== false) {
        return "Hello! I'm Chanikya's portfolio assistant. Ask me about his skills, projects, certifications, education or how to contact him.";
    }

    return "I'm currently running in offline mode. I can tell you about Chanikya's skills, projects, certifications, education and contact details. What would you like to know?";
}
?>

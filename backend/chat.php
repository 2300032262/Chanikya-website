<?php

header('Content-Type: application/json; charset=utf-8');

$API_KEY = getenv('OPENAI_API_KEY');
$data = json_decode(file_get_contents("php://input"), true);
$message = trim($data["message"] ?? "");

if (!$API_KEY || $message === "") {
    http_response_code(400);
    echo json_encode(["reply" => "Chat service unavailable right now."]);
    exit();
}

$postData = [
    "model" => "gpt-4.1-mini",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are the AI assistant for Paruchuru Chanikya's portfolio. Answer questions about his skills, projects, certifications, education and contact details."
        ],
        [
            "role" => "user",
            "content" => $message
        ]
    ]
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $API_KEY,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$result = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($result === false || $error) {
    error_log('Chat API error: ' . $error);
    http_response_code(500);
    echo json_encode(["reply" => "Chat service unavailable. Please try again later."]);
    exit();
}

$response = json_decode($result, true);
$reply = $response["choices"][0]["message"]["content"] ?? "Sorry, I could not generate a response right now.";

echo json_encode(["reply" => $reply]);
?>

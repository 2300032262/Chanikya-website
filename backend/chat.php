<?php

$API_KEY="YOUR_OPENAI_API_KEY";

$data=json_decode(file_get_contents("php://input"),true);

$message=$data["message"];

$postData=[
"model"=>"gpt-4.1-mini",
"messages"=>[
[
"role"=>"system",
"content"=>"You are the AI assistant for Paruchuru Chanikya's portfolio. Answer questions about his skills, projects, certifications, education and contact details."
],
[
"role"=>"user",
"content"=>$message
]
]
];

$ch=curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

curl_setopt($ch,CURLOPT_HTTPHEADER,[

"Authorization: Bearer ".$API_KEY,

"Content-Type: application/json"

]);

curl_setopt($ch,CURLOPT_POST,true);

curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postData));

$result=curl_exec($ch);

curl_close($ch);

$response=json_decode($result,true);

echo json_encode([

"reply"=>$response["choices"][0]["message"]["content"]

]);

?>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$api_key = "AIzaSyDGIfdZWA78GeO6jEspW4_porQCiEU9g48"; // Google Gemini API Key लावा
$input_data = json_decode(file_get_contents("php://input"), true);
$prompt = $input_data["prompt"] ?? "";

$url = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=" . $api_key;
$data = json_encode(["contents" => [["parts" => [["text" => $prompt]]]]]);

$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => $data,
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);

$generated_code = $response['candidates'][0]['content']['parts'][0]['text'] ?? "Error generating code.";

echo json_encode(["generated_code" => $generated_code]);
?>

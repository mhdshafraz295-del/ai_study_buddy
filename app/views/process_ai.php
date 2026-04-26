<?php
include '../../config/ai_config.php';
header('Content-Type: application/json');

function getGeminiSummary() {
    $apiKey = GEMINI_API_KEY;
    // Indha URL-la entha dot-um quotes-um maathaama அப்படியே use pannunga
   $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . GEMINI_API_KEY;

    $prompt = "Summarize this study material and give 5 quiz questions.";
    $data = ["contents" => [["parts" => [["text" => $prompt]]]]];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

echo getGeminiSummary();
?>
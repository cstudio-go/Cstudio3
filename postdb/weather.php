<?php
// weather.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // optional if you only serve from same domain

// CONFIGURATION
$apiKey = '6b12f7b5df46291e70d30327cdb310b0'; // ← keep secret here, not in JS
$city = 'Taipei';
$units = 'metric';

// Make the API call to OpenWeather
$url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units={$units}";

$response = @file_get_contents($url);

if ($response === FALSE) {
    echo json_encode(['ok' => false, 'error' => 'Weather API failed']);
    exit;
}

// Parse and simplify the data
$data = json_decode($response, true);
if (!isset($data['main']['temp'])) {
    echo json_encode(['ok' => false, 'error' => 'Unexpected API data']);
    exit;
}

$temp = round($data['main']['temp'], 1);
$description = ucfirst($data['weather'][0]['description'] ?? 'unknown');

echo json_encode([
    'ok' => true,
    'city' => $city,
    'temp' => $temp,
    'description' => $description
]);

<?php
// Fetch user inputs from the form
$mealType = isset($_GET['mealType']) ? urlencode($_GET['mealType']) : '';
$health = isset($_GET['health']) ? urlencode($_GET['health']) : '';
$include = isset($_GET['include']) ? urlencode($_GET['include']) : '';
$exclude = isset($_GET['exclude']) ? urlencode($_GET['exclude']) : '';

// Edamam API credentials
$app_id = '747edc88'; // Replace with your Edamam App ID
$app_key = 'f9833db515fa1f1cba96cc45dd64b25e'; // Replace with your Edamam App Key

$from = 0; // Start index
$to = 5; // End index (exclusive)

// Construct the API query URL
$api_url = "https://api.edamam.com/api/recipes/v2?type=public&app_id=$app_id&app_key=$app_key";
if (!empty($mealType)) $api_url .= "&mealType=$mealType";
if (!empty($health)) $api_url .= "&health=$health";
if (!empty($include)) $api_url .= "&q=$include";
if (!empty($exclude)) $api_url .= "&excluded=$exclude";
$api_url .= "&from=0&to=3"; // Fetch up to 3 recipes

// Fetch the data using file_get_contents
$response = file_get_contents($api_url);

// Check for errors
if ($response === FALSE) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["success" => false, "message" => "Failed to fetch data from the API."]);
    exit();
}

// Return the API response
header('Content-Type: application/json');
echo $response;
exit();
?>

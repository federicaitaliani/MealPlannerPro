<?php
header('Content-Type: application/json');

// Your Spoonacular API key
$apiKey = "d7ee40b48bfe4a1d941026d5ac5233d2";

// Enable error reporting for debugging (use cautiously in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the recipe ID from the query parameters
$recipeId = $_GET['id'] ?? null;

if (!$recipeId) {
    echo json_encode(['success' => false, 'message' => 'No recipe ID provided.']);
    exit();
}

// Build the API URL for the recipe information
$url = "https://api.spoonacular.com/recipes/{$recipeId}/information?apiKey={$apiKey}";

// Fetch the recipe details from the Spoonacular API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Check for API errors
if ($httpCode !== 200 || !$response) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch recipe details.']);
    exit();
}

// Decode the API response
$data = json_decode($response, true);

if (isset($data['id'])) {
    // Extract equipment from analyzedInstructions
    $equipment = [];
    if (isset($data['analyzedInstructions'][0]['steps'])) {
        foreach ($data['analyzedInstructions'][0]['steps'] as $step) {
            if (isset($step['equipment'])) {
                foreach ($step['equipment'] as $item) {
                    $equipment[] = $item['name'];
                }
            }
        }
    }

    // Remove duplicate equipment entries
    $equipment = array_unique($equipment);

    // Prepare instructions
    $instructions = [];
    if (isset($data['analyzedInstructions'][0]['steps'])) {
        foreach ($data['analyzedInstructions'][0]['steps'] as $step) {
            $instructions[] = $step['step'];
        }
    } elseif (!empty($data['instructions'])) {
        // Fallback if no analyzed instructions
        $instructions = [strip_tags($data['instructions'])];
    }

    // Prepare the recipe data to send to the frontend
    $recipe = [
        'title' => $data['title'] ?? 'No Title Available',
        'image' => $data['image'] ?? 'https://via.placeholder.com/300', // Fallback image
        'ingredients' => array_map(function ($ingredient) {
            return ['name' => $ingredient['original']];
        }, $data['extendedIngredients'] ?? []),
        'equipment' => !empty($equipment) ? $equipment : ['No special equipment needed.'],
        'instructions' => !empty($instructions) ? $instructions : ['No instructions available.'],
    ];

    echo json_encode(['success' => true, 'recipe' => $recipe]);
} else {
    // Log the unexpected API response for debugging
    file_put_contents('debug_recipes.log', $response . PHP_EOL, FILE_APPEND);
    echo json_encode(['success' => false, 'message' => 'Recipe not found or invalid data.']);
}

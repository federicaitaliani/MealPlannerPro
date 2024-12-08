<?php
header('Content-Type: application/json');

// Your Spoonacular API key
$apiKey = "YOUR_API_KEY_HERE";

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
curl_close($ch);

// Decode the API response
$data = json_decode($response, true);

if (isset($data['id'])) {
    // Prepare the recipe data to send to the frontend
    $recipe = [
        'title' => $data['title'],
        'image' => $data['image'],
        'ingredients' => array_map(function ($ingredient) {
            return ['name' => $ingredient['original']];
        }, $data['extendedIngredients'] ?? []),
        'equipment' => array_map(function ($equipment) {
            return $equipment['name'];
        }, $data['equipment'] ?? []),
        'instructions' => $data['instructions'] ?? $data['analyzedInstructions'][0]['steps'] ?? [],
    ];

    // Format instructions as a list of strings
    if (is_array($recipe['instructions'])) {
        $recipe['instructions'] = array_map(function ($step) {
            return $step['step'];
        }, $recipe['instructions']);
    }

    echo json_encode(['success' => true, 'recipe' => $recipe]);
} else {
    echo json_encode(['success' => false, 'message' => 'Recipe not found.']);
}

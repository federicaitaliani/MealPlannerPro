<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Get the recipe ID from the query string
$recipeId = isset($_GET['id']) ? $_GET['id'] : null;

if ($recipeId) {
    // Your API key
    $apiKey = "3c77525db565413abf818b2e2fb68b80";

    // Fetch recipe details using the recipe ID
    $url = "https://api.spoonacular.com/recipes/$recipeId/information?apiKey=$apiKey";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response
    $recipeDetails = json_decode($response, true);

    // Initialize response data
    $recipeData = [];

    if ($recipeDetails) {
        // Extract recipe title, image, and other details
        $recipeData['title'] = $recipeDetails['title'];
        $recipeData['image'] = $recipeDetails['image'];
        $recipeData['calories'] = $recipeDetails['calories'];
        
        // Extract ingredients
        $ingredients = $recipeDetails['extendedIngredients'] ?? [];
        $ingredientList = [];
        foreach ($ingredients as $ingredient) {
            $ingredientList[] = [
                'name' => $ingredient['original'],
                'image' => "https://spoonacular.com/cdn/ingredients_100x100/{$ingredient['image']}"
            ];
        }
        $recipeData['ingredients'] = $ingredientList;

        // Extract equipment
        $equipmentList = [];
        if (isset($recipeDetails['analyzedInstructions'][0]['steps'])) {
            foreach ($recipeDetails['analyzedInstructions'][0]['steps'] as $step) {
                if (isset($step['equipment'])) {
                    foreach ($step['equipment'] as $equip) {
                        $equipmentList[] = $equip['name'];
                    }
                }
            }
        }
        $recipeData['equipment'] = $equipmentList;

        // Extract instructions
        $instructions = $recipeDetails['instructions'] ?? 'Instructions not available';
        $recipeData['instructions'] = $instructions;
        
        // Return JSON response
        echo json_encode([
            'success' => true,
            'recipe' => $recipeData
        ]);
    } else {
        // If recipe details are not found, return an error
        echo json_encode([
            'success' => false,
            'message' => 'Recipe not found or API call failed'
        ]);
    }
} else {
    // If no recipe ID is provided
    echo json_encode([
        'success' => false,
        'message' => 'No recipe ID provided'
    ]);
}
?>

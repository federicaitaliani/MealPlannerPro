<?php
// data for recipes and ingredients (replace with database queries).
$recipes = [
    "Spaghetti" => ["Pasta", "Tomato Sauce", "Ground Beef", "Garlic"],
    "Salad" => ["Lettuce", "Tomato", "Cucumber", "Dressing"],
    "Burger" => ["Buns", "Beef Patty", "Lettuce", "Cheese"]
];

// Get selected recipes from POST data
$selected_recipes = $_POST['recipes'] ?? []; // Array of recipe names

// Combine ingredients
$shopping_list = [];
foreach ($selected_recipes as $recipe) {
    if (isset($recipes[$recipe])) {
        $shopping_list = array_merge($shopping_list, $recipes[$recipe]);
    }
}

// Remove duplicates and reindex
$shopping_list = array_unique($shopping_list);

// Send back as JSON (or render directly)
header('Content-Type: application/json');
echo json_encode($shopping_list);
?>

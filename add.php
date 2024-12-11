<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch meals for the logged-in user
    $stmt = $conn->prepare("SELECT ingredients FROM meals WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row; // Collect all recipes
    }

    // Function to parse and aggregate ingredients
    function parseAndAggregateIngredients($recipes) {
        $ingredientMap = [];
        $instructionWords = ['mix', 'stir', 'boil', 'combine', 'chop', 'add', 'blend', 'pour', 'cook', 'heat', 'bake', 'simmer', 'serve', 'set aside'];
        $units = ['cup', 'tsp', 'tbsp', 'oz', 'lb', 'kg', 'g', 'ml', 'l', 'pinch', 'dash']; // Supported units

        foreach ($recipes as $recipe) {
            $ingredients = explode(',', $recipe['ingredients']); // Split ingredients string
            foreach ($ingredients as $ingredient) {
                $cleanedIngredient = strtolower(trim($ingredient));

                // Remove instruction words
                foreach ($instructionWords as $word) {
                    $cleanedIngredient = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '', $cleanedIngredient);
                }

                // Extract quantity, unit, and ingredient name
                if (preg_match('/(\d+(?:\.\d+)?(?:\s?\/\s?\d+)?)\s*(' . implode('|', $units) . ')?\s*(.*)/', $cleanedIngredient, $matches)) {
                    $quantity = floatval(eval("return {$matches[1]};")); // Convert fractions to decimals
                    $unit = isset($matches[2]) ? $matches[2] : ''; // Optional unit
                    $name = strtolower(trim($matches[3])); // Ingredient name

                    // Aggregate quantities
                    $key = $unit ? "$unit $name" : $name; // Combine unit and name for unique keys
                    if (!empty($name)) {
                        if (isset($ingredientMap[$key])) {
                            $ingredientMap[$key] += $quantity;
                        } else {
                            $ingredientMap[$key] = $quantity;
                        }
                    }
                }
            }
        }

        return $ingredientMap; // Return aggregated ingredients
    }

    // Aggregate ingredients
    $aggregatedIngredients = parseAndAggregateIngredients($recipes);

    // Send response
    echo json_encode(["success" => true, "ingredients" => $aggregatedIngredients]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

// Close database connection
$conn->close();
?>

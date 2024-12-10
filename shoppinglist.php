<?php
// shoppinglist.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
header('Content-Type: application/json');

// Database connection
$userId = $_POST['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit();
}

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Fetch the meal plan for the given user
$query = "SELECT meal_plan_data FROM meal_plans WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$mealPlans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Aggregate ingredients into a shopping list
$shoppingList = [];

foreach ($mealPlans as $plan) {
    // Decode the JSON meal plan
    $meals = json_decode($plan['meal_plan_data'], true);
    
    if ($meals && is_array($meals)) {
        foreach ($meals as $meal) {
            if (isset($meal['ingredients']) && is_array($meal['ingredients'])) {
                foreach ($meal['ingredients'] as $ingredient) {
                    // Ensure 'name' and 'quantity' keys exist in the ingredient data
                    $ingredientName = $ingredient['name'] ?? null;
                    $ingredientQuantity = (float)($ingredient['quantity'] ?? 0);

                    if ($ingredientName) {
                        // Add to shopping list or update quantity
                        if (isset($shoppingList[$ingredientName])) {
                            $shoppingList[$ingredientName] += $ingredientQuantity;
                        } else {
                            $shoppingList[$ingredientName] = $ingredientQuantity;
                        }
                    }
                }
            }
        }
    }
}

// Prepare the shopping list for display
if (empty($shoppingList)) {
    echo json_encode(['success' => false, 'message' => 'No ingredients found for this user.']);
    exit();
}

$shoppingListHtml = "<ul>";
foreach ($shoppingList as $ingredient => $quantity) {
    $shoppingListHtml .= "<li>{$ingredient}: {$quantity} units</li>";
}
$shoppingListHtml .= "</ul>";

// Render the shopping list page
echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "    <meta charset='UTF-8'>\n";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
echo "    <title>Shopping List</title>\n";
echo "    <style>\n";
echo "        body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }\n";
echo "        h1 { color: #333; }\n";
echo "        ul { list-style-type: disc; padding-left: 20px; }\n";
echo "        li { margin: 5px 0; }\n";
echo "    </style>\n";
echo "</head>\n";
echo "<body>\n";
echo "    <h1>Shopping List</h1>\n";
echo "    <p>Below is the aggregated shopping list based on the meal plans:</p>\n";
echo "    {$shoppingListHtml}\n";
echo "</body>\n";
echo "</html>\n";
?>

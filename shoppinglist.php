<?php
// shoppinglist.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include your database connection
header('Content-Type: application/json'); // Set content type as JSON

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

// Return the shopping list as JSON
echo json_encode(['success' => true, 'shoppingList' => $shoppingList]);

?>

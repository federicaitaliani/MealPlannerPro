<?php
header('Content-Type: application/json');
include 'db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get POST data
$userId = $_POST['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit();
}

// Fetch meal plans for the user
try {
    $stmt = $pdo->prepare("SELECT meal_plan_data FROM meal_plans WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $mealPlans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$mealPlans) {
        echo json_encode(['success' => false, 'message' => 'No meal plans found for this user.']);
        exit();
    }

    $combinedIngredients = [];

    // Iterate through meal plans and combine ingredients
    foreach ($mealPlans as $plan) {
        $mealPlanData = json_decode($plan['meal_plan_data'], true);

        if (!$mealPlanData || !is_array($mealPlanData)) {
            continue; // Skip invalid or empty meal plan data
        }

        foreach ($mealPlanData as $meal) {
            if (isset($meal['ingredients']) && is_array($meal['ingredients'])) {
                $combinedIngredients = array_merge($combinedIngredients, $meal['ingredients']);
            }
        }
    }

    // Remove duplicates and return the shopping list
    $combinedIngredients = array_unique($combinedIngredients);
    echo json_encode(['success' => true, 'shoppingList' => $combinedIngredients]);

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

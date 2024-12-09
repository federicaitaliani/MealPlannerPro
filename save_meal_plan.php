<?php
header('Content-Type: application/json');
include 'db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get POST data
$mealPlan = $_POST['mealPlan'] ?? null;
$planName = $_POST['planName'] ?? 'Unnamed Plan';
$userId = 1; // Replace with session-based user ID when authentication is implemented

if (!$mealPlan) {
    echo json_encode(['success' => false, 'message' => 'No meal plan data provided.']);
    exit();
}

// Decode the JSON meal plan
$mealPlanArray = json_decode($mealPlan, true);
if (!$mealPlanArray) {
    echo json_encode(['success' => false, 'message' => 'Invalid meal plan format.']);
    exit();
}

// Serialize the meal plan for storage
$serializedMealPlan = json_encode($mealPlanArray);

// Insert into database
try {
    $stmt = $pdo->prepare("INSERT INTO meal_plans (user_id, plan_name, meal_plan_data) VALUES (:user_id, :plan_name, :meal_plan_data)");
    $stmt->execute([
        ':user_id' => $userId,
        ':plan_name' => $planName,
        ':meal_plan_data' => $serializedMealPlan,
    ]);

    // Respond with success, and let the frontend handle redirection
    echo json_encode(['success' => true, 'message' => 'Meal plan saved successfully.']);
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

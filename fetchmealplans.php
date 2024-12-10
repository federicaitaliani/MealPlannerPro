<?php
header('Content-Type: application/json');
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userId = 1;

try {
    $stmt = $pdo->prepare("SELECT plan_name, meal_plan_data FROM meal_plans WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $mealPlans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($mealPlans)) {
        echo json_encode(['success' => false, 'message' => 'No meal plans found.']);
        exit();
    }

    echo json_encode(['success' => true, 'mealPlans' => $mealPlans]);
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

?>

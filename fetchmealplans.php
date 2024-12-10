<?php
header('Content-Type: application/json');
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming the user is authenticated, and their user ID is stored in the session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Retrieve the logged-in user's ID
$userId = $_SESSION['user_id'];  // Adjust this based on how you're storing user session data

try {
    $stmt = $pdo->prepare("SELECT id, plan_name, meal_plan_data, user_id FROM meal_plans WHERE user_id = :user_id");
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

<?php
session_start();
require_once 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session

try {
    // Fetch meals for the logged-in user
    $stmt = $pdo->prepare("SELECT id, name, image, url, ingredients FROM meals WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'meals' => $meals]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

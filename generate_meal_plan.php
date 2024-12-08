<?php
// Start the session
session_start();

// Include your database connection
include 'db.php';
header('Content-Type: application/json');

// API Key
$apiKey = "fbd430d48e5a4d1bbe7dbb6190c3b135";

// Get user input
$preferences = $_POST['preferences'] ?? 'any';
$calories = $_POST['calories'] ?? 2000;
$budget = $_POST['budget'] ?? 50;

// Meal calorie allocation
$mealCalories = [
    'breakfast' => intval($calories * 0.3),
    'lunch' => intval($calories * 0.4),
    'dinner' => intval($calories * 0.3)
];

$mealPlan = [];
foreach ($mealCalories as $meal => $mealCalorie) {
    $url = "https://api.spoonacular.com/recipes/complexSearch?apiKey=$apiKey&diet=$preferences&maxCalories=$mealCalorie&number=1";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (!empty($data['results'])) {
        $mealPlan[$meal] = [
            'title' => $data['results'][0]['title'],
            'image' => $data['results'][0]['image'],
            'link' => "https://spoonacular.com/recipes/" . $data['results'][0]['id'],
            'calories' => $mealCalorie,
            'ingredients' => [] // Add logic to fetch ingredient details if necessary
        ];
    }
}

// Store meal plan in session
$_SESSION['mealPlan'] = $mealPlan;

// Return success response
echo json_encode(['success' => true]);
?>


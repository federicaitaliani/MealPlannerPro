<?php
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
    'breakfast' => intval($calories * 0.25),
    'lunch' => intval($calories * 0.35),
    'dinner' => intval($calories * 0.40),
];

$mealPlan = [];
$debugInfo = []; // Store debug data here

foreach ($mealCalories as $mealType => $calorieLimit) {
    // Build the API URL
    $url = "https://api.spoonacular.com/recipes/complexSearch?apiKey=$apiKey&diet=$preferences&type=$mealType&maxCalories=$calorieLimit&addRecipeInformation=true&sort=random&number=1";

    // Make API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // Debug information
    $debugInfo[$mealType] = [
        'url' => $url,
        'response' => $response,
    ];

    $data = json_decode($response, true);

    if (isset($data['results'][0])) {
        $recipe = $data['results'][0];
        $mealPlan[$mealType] = [
            'title' => $recipe['title'],
            'calories' => $recipe['nutrition']['nutrients'][0]['amount'] ?? 'Unknown',
            'image' => $recipe['image'],
            'link' => "https://spoonacular.com/recipes/" . $recipe['title'] . "-" . $recipe['id'],
        ];
    } else {
        $mealPlan[$mealType] = [
            'title' => 'No recipe found',
            'calories' => 'N/A',
            'image' => 'https://via.placeholder.com/150',
            'link' => '#',
        ];
    }
}

// Return the meal plan along with debug info
echo json_encode([
    'success' => true,
    'mealPlan' => $mealPlan,
    'debug' => $debugInfo,
]);
exit();
?>

<?php
header('Content-Type: application/json'); // Set the response type to JSON

// Your API key
$apiKey = "3c77525db565413abf818b2e2fb68b80";

// Get user inputs
$preferences = $_POST['preferences'] ?? 'any';
$totalCalories = intval($_POST['calories']) ?? 14000; // Weekly calorie goal
$totalBudget = floatval($_POST['budget']) ?? 100;     // Weekly budget

// Split calories across 7 days and 3 meals/day
$caloriesPerDay = $totalCalories / 7;
$caloriesPerMeal = [
    'breakfast' => intval($caloriesPerDay * 0.25),
    'lunch' => intval($caloriesPerDay * 0.35),
    'dinner' => intval($caloriesPerDay * 0.40),
];

// Split the total budget across 7 days
$budgetPerDay = $totalBudget / 7;
$budgetPerMeal = [
    'breakfast' => $budgetPerDay * 0.25,
    'lunch' => $budgetPerDay * 0.35,
    'dinner' => $budgetPerDay * 0.40,
];

// Initialize meal plan
$mealPlan = [];

// Loop through each day and meal type
$daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
foreach ($daysOfWeek as $day) {
    $mealPlan[$day] = [];
    foreach ($caloriesPerMeal as $mealType => $calorieLimit) {
        // Build API URL for each meal
        $url = "https://api.spoonacular.com/recipes/complexSearch?apiKey=$apiKey&diet=$preferences&type=$mealType&maxCalories=$calorieLimit&addRecipeInformation=true&sort=random&number=5";

        // Fetch the data from the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode API response
        $data = json_decode($response, true);

        // Select a recipe within the budget
        $selectedRecipe = null;
        if (isset($data['results'])) {
            foreach ($data['results'] as $recipe) {
                if (isset($recipe['pricePerServing'])) {
                    $costPerServing = $recipe['pricePerServing'] / 100; // Convert cents to dollars
                    if ($costPerServing <= $budgetPerMeal[$mealType]) {
                        $selectedRecipe = $recipe;
                        break;
                    }
                }
            }
        }

        // If a recipe is found, add it to the meal plan
        if ($selectedRecipe) {
            $mealPlan[$day][$mealType] = [
                'title' => $selectedRecipe['title'],
                'calories' => $calorieLimit, // Assumes calorie limit for now
                'cost' => number_format($selectedRecipe['pricePerServing'] / 100, 2), // Cost for one serving
                'image' => $selectedRecipe['image'],
                'link' => "https://spoonacular.com/recipes/" . $selectedRecipe['title'] . "-" . $selectedRecipe['id'],
            ];
        } else {
            // Fallback for missing recipes or budget constraints
            $mealPlan[$day][$mealType] = [
                'title' => 'No recipe found (Budget exceeded)',
                'calories' => 'N/A',
                'cost' => 'N/A',
                'image' => 'https://via.placeholder.com/150',
                'link' => '#',
            ];
        }
    }
}

// Return the meal plan as JSON
echo json_encode(['success' => true, 'mealPlan' => $mealPlan]);

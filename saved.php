// <?php
// session_start();
// require_once 'db.php'; // Include database connection

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'User not logged in.']);
//     exit();
// }

// $user_id = $_SESSION['user_id']; // Get user ID from session

// try {
//     // Fetch meals for the logged-in user
//     $stmt = $pdo->prepare("SELECT id, name, image, url, ingredients FROM meals WHERE user_id = ?");
//     $stmt->execute([$user_id]);
//     $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     echo json_encode(['success' => true, 'meals' => $meals]);
// } catch (PDOException $e) {
//     echo json_encode(['success' => false, 'message' => $e->getMessage()]);
// }
// ?>

<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Prepare and execute the SQL query
    $sql = "SELECT id, name, image, url, ingredients FROM meals WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all meals for the logged-in user
    $meals = [];
    while ($row = $result->fetch_assoc()) {
        $row['ingredients'] = json_encode(json_decode($row['ingredients'], true)); // Ensure ingredients remain JSON encoded
        $meals[] = $row;
    }

    // Send success response with meals
    echo json_encode(["success" => true, "meals" => $meals]);
} catch (Exception $e) {
    // Handle exceptions and send error response
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

// Close database connection
$conn->close();
?>


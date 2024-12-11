<?php
// chatbot.php
header('Content-Type: application/json');

// Database connection
$host = "localhost"; // Replace with your host
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "chatbot";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Get user input
$userInput = trim($_POST['user_input']);

// Query database for matching response
$query = $conn->prepare("SELECT bot_response FROM chat_responses WHERE user_input = ?");
$query->bind_param("s", $userInput);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $response = $result->fetch_assoc()['bot_response'];
} else {
    $response = "Sorry, I don't understand that.";
}

echo json_encode(["response" => $response]);
$conn->close();
?>

<?php
session_start();

// Check if the token is provided and valid
if (!isset($_GET['token']) || empty($_GET['token'])) {
    die("Invalid or missing token.");
}

// Sanitize the token to prevent XSS or other attacks
$token = htmlspecialchars($_GET['token']);

// Establish a database connection
$conn = new mysqli("localhost", "root", "", "MyCustomDB");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if the token exists and the user is not already verified
$stmt = $conn->prepare("SELECT ID, Username, Role FROM SystemUser WHERE verification_token = ? AND is_verified = 0");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user's details
    $row = $result->fetch_assoc();
    $userId = $row['ID'];

    // Update the user's verification status
    $updateStmt = $conn->prepare("UPDATE SystemUser SET is_verified = 1, verification_token = NULL WHERE ID = ?");
    $updateStmt->bind_param("i", $userId);
    $updateStmt->execute();
    $updateStmt->close();

    // Log the user in by setting session variables
    $_SESSION['username'] = $row['Username'];
    $_SESSION['role'] = $row['Role'];

    // Redirect the user to the evaluation request page
    header("Location: evaluationRequest.php");
    exit;
} else {
    // If the token is invalid or expired, show an error message
    echo "<div style='font-family: Arial, sans-serif; background-color: #f8d7da; color: #842029; padding: 20px; border-radius: 5px; max-width: 500px; margin: 50px auto;'>
            Invalid or expired verification token.
          </div>";
}

// Close the database connections
$stmt->close();
$conn->close();
?>

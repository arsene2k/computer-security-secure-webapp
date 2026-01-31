<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("You must log in to access this page.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "MyCustomDB");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get form inputs
$userEmail = $_SESSION['username'];
$details = htmlspecialchars($_POST['details']);
$contactMethod = $_POST['contactMethod'];

// Handle file upload
$photo = $_FILES['photo'];
$uploadDir = "uploads/";
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB

// Validate file upload
if ($photo['error'] !== UPLOAD_ERR_OK) {
    die("File upload error. Please try again.");
}

if (!in_array($photo['type'], $allowedTypes)) {
    die("Invalid file type. Only JPG, PNG, and GIF files are allowed.");
}

if ($photo['size'] > $maxFileSize) {
    die("File size exceeds the 2MB limit.");
}

// Sanitize and create unique filename
$fileExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
$uniqueFilename = uniqid() . '.' . $fileExtension;
$photoPath = $uploadDir . $uniqueFilename;

// Move the file securely to the uploads directory
if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
    die("Failed to upload photo.");
}

// Insert the request into the database
$stmt = $conn->prepare("INSERT INTO EvaluationRequests (UserEmail, Details, ContactMethod, PhotoPath) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $userEmail, $details, $contactMethod, $photoPath);

if ($stmt->execute()) {
    echo "Request submitted successfully!";
} else {
    echo "Failed to submit the request.";
}

$stmt->close();
$conn->close();
?>

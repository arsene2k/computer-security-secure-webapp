<?php
session_start();
$conn = new mysqli("localhost", "root", "", "MyCustomDB");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate passwords
    if (empty($newPassword) || empty($confirmPassword)) {
        die("Both password fields are required.");
    }
    if ($newPassword !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Verify token again for security
    $stmt = $conn->prepare("SELECT ResetExpires FROM SystemUser WHERE Email = ? AND ResetToken = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid or expired reset token.");
    }

    $user = $result->fetch_assoc();
    $expires = $user['ResetExpires'];

    // Check if the token has expired
    if (strtotime($expires) < time()) {
        die("Reset token has expired. Please request a new reset link.");
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $updateStmt = $conn->prepare("UPDATE SystemUser SET Password = ?, ResetToken = NULL, ResetExpires = NULL WHERE Email = ?");
    $updateStmt->bind_param("ss", $hashedPassword, $email);

    if ($updateStmt->execute()) {
        // Password reset successful
        echo "Password has been reset successfully! <a href='complexLoginForm.php'>Click here to login</a>";
    } else {
        echo "Failed to reset password. Please try again.";
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>

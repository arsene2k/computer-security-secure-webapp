<?php
session_start();
require 'functions.php'; // Include CSRF functions
require 'vendor/autoload.php'; // Include PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die("CSRF validation failed.");
    }

    $name = htmlspecialchars($_POST['txtName']);
    $email = htmlspecialchars($_POST['txtEmail']);
    $phone = htmlspecialchars($_POST['txtPhone']);
    $username = htmlspecialchars($_POST['txtUsername']);
    $password = $_POST['txtPassword'];
    $confirmPassword = $_POST['txtConfirmPassword'];
    $securityQuestion = htmlspecialchars($_POST['securityQuestion']);
    $securityAnswer = htmlspecialchars($_POST['securityAnswer']);

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $hashedAnswer = password_hash($securityAnswer, PASSWORD_BCRYPT);
    $verificationToken = bin2hex(random_bytes(16)); // Generate unique token

    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO SystemUser (Name, Email, Phone, Username, Password, SecurityQuestion, SecurityAnswer, verification_token, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $username, $hashedPassword, $securityQuestion, $hashedAnswer, $verificationToken);

    if ($stmt->execute()) {
        $verificationLink = "http://localhost/INTROcompsec/Assigment/verifyEmail.php?token=$verificationToken";

        // Send the verification email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arseneplaystation4@gmail.com'; 
            $mail->Password = 'bvdvyllqzkxoirzi';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('arseneplaystation4@gmail.com', 'Support Team');
            $mail->addAddress($email);

            $mail->Subject = 'Verify Your Email';
            $mail->Body = "Hello $name,\n\nPlease verify your email by clicking the link below:\n$verificationLink";

            $mail->send();
            echo "Registration successful! Please check your email to verify your account.";
        } catch (Exception $e) {
            die("Email sending failed: " . $mail->ErrorInfo);
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

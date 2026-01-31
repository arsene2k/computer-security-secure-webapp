<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = 'arseneintwari2k@gmail.com'; // Recipient email

    // Database connection
    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT ID FROM SystemUser WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate reset token and expiration
        $resetToken = bin2hex(random_bytes(16));
        $resetExpires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Update database
        $updateStmt = $conn->prepare("UPDATE SystemUser SET ResetToken = ?, ResetExpires = ? WHERE Email = ?");
        $updateStmt->bind_param("sss", $resetToken, $resetExpires, $email);
        if ($updateStmt->execute()) {
            // Send reset email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0; // Disable verbose debug output for production
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'arseneplaystation4@gmail.com'; // Sender's Gmail
                $mail->Password = 'bvdvyllqzkxoirzi';             // Sender's app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('arseneplaystation4@gmail.com', 'Support Team'); // Sender email
                $mail->addAddress('arseneintwari2k@gmail.com'); // Recipient email

                // Email content
                $mail->Subject = 'Password Reset Request';
              
              $mail->Body = "Hello,\n\nClick the link below to reset your password:\n\n" .
              "http://127.0.0.1/INTROcompsec/Assigment/resetPassword.php?token=$resetToken";



            

                $mail->send();
                echo "A password reset link has been sent to arseneintwari2k@gmail.com.";
            } catch (Exception $e) {
                echo "Failed to send email. Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Failed to generate reset link.";
        }
        $updateStmt->close();
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

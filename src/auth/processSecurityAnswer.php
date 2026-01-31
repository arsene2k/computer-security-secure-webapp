<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is installed and included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $securityAnswer = $_POST['securityAnswer'];

    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT SecurityAnswer, ResetToken FROM SystemUser WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($securityAnswer, $row['SecurityAnswer'])) {
            $resetToken = $row['ResetToken'];

            // Generate a new token if one doesn't exist
            if (empty($resetToken)) {
                $resetToken = bin2hex(random_bytes(16));
                $resetExpires = date("Y-m-d H:i:s", strtotime("+1 hour"));
                $updateStmt = $conn->prepare("UPDATE SystemUser SET ResetToken = ?, ResetExpires = ? WHERE Email = ?");
                $updateStmt->bind_param("sss", $resetToken, $resetExpires, $email);
                $updateStmt->execute();
                $updateStmt->close();
            }

            // Send email with reset link
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
                $mail->addAddress('arseneintwari2k@gmail.com');

                $resetLink = "http://127.0.0.1/INTROcompsec/Assigment/resetPassword.php?token=" . urlencode($resetToken);

                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Hello,\n\nWe received a request to reset your password. Click the link below to reset your password:\n\n" . $resetLink . "\n\nIf you did not request this, please ignore this email.";

                $mail->send();
                echo "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                echo "Failed to send email. Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Incorrect security answer. Please try again.";
        }
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

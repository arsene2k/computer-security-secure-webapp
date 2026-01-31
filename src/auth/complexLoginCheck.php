<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is included
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed.");
    }

    $user = htmlspecialchars($_POST['txtUsername']);
    $pass = $_POST['txtPassword'];

    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT ID, Username, Password, is_verified, Email FROM SystemUser WHERE Username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['is_verified'] == 0) {
            die("Account not verified. Please check your email to verify your account.");
        }

        if (password_verify($pass, $row['Password'])) {
            // Generate a 6-digit 2FA PIN
            $twoFactorPin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $twoFactorExpires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            // Save PIN and expiration in the database
            $updateStmt = $conn->prepare("UPDATE SystemUser SET TwoFactorPin = ?, TwoFactorExpires = ? WHERE ID = ?");
            $updateStmt->bind_param("ssi", $twoFactorPin, $twoFactorExpires, $row['ID']);
            $updateStmt->execute();
            $updateStmt->close();

            // Send PIN via email
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
                $mail->addAddress($row['Email']);

                $mail->Subject = 'Your 2FA PIN';
                $mail->Body = "Hello, your 2FA PIN is: $twoFactorPin\nIt will expire in 5 minutes.";

                $mail->send();
            } catch (Exception $e) {
                die("Failed to send 2FA email: " . $mail->ErrorInfo);
            }

            // Redirect to 2FA page
            $_SESSION['pending_2fa_user'] = $row['ID'];
            header("Location: twoFactorAuth.php");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

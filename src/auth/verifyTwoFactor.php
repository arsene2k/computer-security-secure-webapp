<?php
session_start();

if (!isset($_SESSION['pending_2fa_user'])) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed.");
    }

    $userId = $_SESSION['pending_2fa_user'];
    $enteredPin = htmlspecialchars($_POST['twoFactorPin']);

    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT TwoFactorPin, TwoFactorExpires, Role, Username FROM SystemUser WHERE ID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($enteredPin === $row['TwoFactorPin'] && strtotime($row['TwoFactorExpires']) > time()) {
            // Log in the user
            $_SESSION['username'] = $row['Username'];
            $_SESSION['role'] = $row['Role'];
            unset($_SESSION['pending_2fa_user']);

            // Clear the PIN from the database
            $clearStmt = $conn->prepare("UPDATE SystemUser SET TwoFactorPin = NULL, TwoFactorExpires = NULL WHERE ID = ?");
            $clearStmt->bind_param("i", $userId);
            $clearStmt->execute();
            $clearStmt->close();

            // Redirect based on role
            if ($row['Role'] === 'admin') {
                header("Location: adminRequestList.php");
            } else {
                header("Location: evaluationRequest.php");
            }
            exit;
        } else {
            echo "Invalid or expired PIN.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

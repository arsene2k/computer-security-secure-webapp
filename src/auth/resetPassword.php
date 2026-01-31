<?php
// Start session and include database connection
session_start();
$conn = new mysqli("localhost", "root", "", "MyCustomDB");

// Check if the token is in the URL
if (!isset($_GET['token']) || empty($_GET['token'])) {
    die("Invalid or missing token.");
}
$token = $_GET['token'];

// Verify the token in the database
$stmt = $conn->prepare("SELECT Email, ResetExpires FROM SystemUser WHERE ResetToken = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid or expired reset token.");
}

$user = $result->fetch_assoc();
$email = $user['Email'];
$expires = $user['ResetExpires'];

// Check if the token has expired
if (strtotime($expires) < time()) {
    die("Reset token has expired. Please request a new reset link.");
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script>
        function validatePasswordStrength(password) {
            const strengthText = document.getElementById('strengthText');
            if (!strengthText) return;

            const regex = {
                uppercase: /[A-Z]/,
                lowercase: /[a-z]/,
                digit: /\\d/,
                length: /.{8,}/
            };

            let strength = 0;
            if (regex.uppercase.test(password)) strength++;
            if (regex.lowercase.test(password)) strength++;
            if (regex.digit.test(password)) strength++;
            if (regex.length.test(password)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    strengthText.textContent = 'Weak';
                    strengthText.style.color = 'red';
                    break;
                case 2:
                    strengthText.textContent = 'Fair';
                    strengthText.style.color = 'orange';
                    break;
                case 3:
                    strengthText.textContent = 'Good';
                    strengthText.style.color = 'blue';
                    break;
                case 4:
                    strengthText.textContent = 'Strong';
                    strengthText.style.color = 'green';
                    break;
            }
        }

        function togglePasswordVisibility() {
            const passwordField = document.getElementById('newPassword');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }
    </script>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form method="POST" action="processResetPassword.php">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" oninput="validatePasswordStrength(this.value)" required>
        <span id="strengthText"></span>
        <br>
        <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
        <br><br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

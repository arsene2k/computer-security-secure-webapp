<?php
session_start();

// Check if a CSRF token exists in the session. If not, generate a new one for security.
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random CSRF token
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* CSS styling for the page - unchanged */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .extra-links {
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <!-- Login form where users can enter their credentials -->
        <form action="complexLoginCheck.php" method="POST">
            <!-- Input field for the username -->
            <label for="txtUsername">Username:</label>
            <input name="txtUsername" type="text" id="txtUsername" required>

            <!-- Input field for the password -->
            <label for="txtPassword">Password:</label>
            <input name="txtPassword" id="passwordField" type="password" required>
            
            <!-- Checkbox to toggle the visibility of the password -->
            <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password

            <!-- Include the CSRF token as a hidden field for security -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <!-- Button to submit the login form -->
            <button type="submit">Login</button>
        </form>

        <!-- Links to registration and password recovery pages -->
        <div class="extra-links">
            Not registered yet? <a href="registrationForm.php">Click here</a> |
            Forgot your password? <a href="forgotPasswordForm.php">Click here</a>
        </div>
    </div>

    <script>
        // Toggles the password visibility in the input field
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('passwordField');
            // Switch between 'password' and 'text' types to show or hide the password
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>

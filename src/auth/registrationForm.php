<?php
session_start();
require 'functions.php'; // Include CSRF functions for security
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* General styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background for better readability */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Form container styling */
        .form-container {
            background: #fff; /* White background for contrast */
            padding: 20px;
            border-radius: 8px; /* Smooth rounded edges */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow effect */
            max-width: 400px;
            width: 100%;
        }

        /* Centered heading for the form */
        h2 {
            text-align: center;
            color: #333; /* Dark gray for the heading */
            margin-bottom: 20px;
        }

        /* Labels for input fields */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Input and select field styling */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%; /* Full width for inputs */
            padding: 10px;
            margin-bottom: 15px; /* Space between fields */
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px; /* Rounded edges for a modern look */
            font-size: 14px; /* Standard font size */
        }

        /* Password strength feedback styling */
        #strengthText {
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Submit button styling */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745; /* Green button for submission */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer; /* Pointer cursor for buttons */
        }

        /* Submit button hover effect */
        input[type="submit"]:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Checkbox styling for "Show Password" */
        input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <!-- Registration form for new users -->
        <form action="registerUser.php" method="POST">
            <!-- Input for the user's name -->
            <label for="txtName">Name:</label>
            <input name="txtName" type="text" id="txtName" required />

            <!-- Input for the user's email -->
            <label for="txtEmail">Email:</label>
            <input name="txtEmail" type="email" id="txtEmail" required />

            <!-- Input for the user's phone number -->
            <label for="txtPhone">Phone Number:</label>
            <input name="txtPhone" type="text" id="txtPhone" required />

            <!-- Input for the username -->
            <label for="txtUsername">Username:</label>
            <input name="txtUsername" type="text" id="txtUsername" required />

            <!-- Input for the password -->
            <label for="txtPassword">Password:</label>
            <input name="txtPassword" type="password" id="passwordField" oninput="validatePasswordStrength(this.value)" required />
            <!-- Display password strength -->
            <span id="strengthText"></span>
            <!-- Checkbox to toggle password visibility -->
            <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password

            <!-- Input for confirming the password -->
            <label for="txtConfirmPassword">Confirm Password:</label>
            <input name="txtConfirmPassword" type="password" id="txtConfirmPassword" required />

            <!-- Dropdown for selecting a security question -->
            <label for="securityQuestion">Security Question:</label>
            <select name="securityQuestion" id="securityQuestion" required>
                <option value="What is your mother’s maiden name?">What is your mother’s maiden name?</option>
                <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                <option value="What was the make of your first car?">What was the make of your first car?</option>
            </select>

            <!-- Input for answering the security question -->
            <label for="securityAnswer">Answer to Security Question:</label>
            <input name="securityAnswer" type="text" id="securityAnswer" required />

            <!-- Hidden input for CSRF token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">

            <!-- Submit button to register the user -->
            <input type="submit" value="Register" />
        </form>
    </div>

    <script>
        // Validate the strength of the entered password
        function validatePasswordStrength(password) {
            const strengthText = document.getElementById('strengthText');
            if (!strengthText) return;

            // Regular expressions to check password strength
            const regex = {
                uppercase: /[A-Z]/, // Must include uppercase letters
                lowercase: /[a-z]/, // Must include lowercase letters
                digit: /\d/, // Must include digits
                length: /.{8,}/ // Must be at least 8 characters long
            };

            let strength = 0;
            if (regex.uppercase.test(password)) strength++;
            if (regex.lowercase.test(password)) strength++;
            if (regex.digit.test(password)) strength++;
            if (regex.length.test(password)) strength++;

            // Display feedback on password strength
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

        // Toggles the visibility of the password field
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('passwordField');
            // Switch between 'password' and 'text' types to show or hide the password
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>

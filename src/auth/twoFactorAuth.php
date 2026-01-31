<?php
session_start();

// Ensure the user has initiated the 2FA process
if (!isset($_SESSION['pending_2fa_user'])) {
    die("Unauthorized access. Please log in first.");
}

// Generate a CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    <style>
        /* General page styling */
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
            padding: 20px 30px;
            border-radius: 8px; /* Smooth edges */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Page heading styling */
        h2 {
            color: #333; /* Dark gray for the heading */
            margin-bottom: 20px;
        }

        /* Input field styling */
        input[type="text"] {
            width: 100%; /* Full width for better usability */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px;
            font-size: 14px;
        }

        /* Submit button styling */
        button[type="submit"] {
            width: 100%; /* Full width button */
            padding: 10px;
            font-size: 16px;
            background-color: #007BFF; /* Blue for submit button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer; /* Pointer cursor for buttons */
        }

        /* Hover effect for submit button */
        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Page heading -->
        <h2>Two-Factor Authentication</h2>

        <!-- Form for entering the 2FA PIN -->
        <form action="verifyTwoFactor.php" method="POST">
            <!-- Input field for the PIN sent to the user's email -->
            <label for="twoFactorPin">Enter the PIN sent to your email:</label>
            <input id="twoFactorPin" name="twoFactorPin" type="text" maxlength="6" required />

            <!-- Hidden field for CSRF token to ensure secure submissions -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />

            <!-- Submit button to verify the PIN -->
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>

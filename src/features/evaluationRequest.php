<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("You must log in to access this page. <a href='complexLoginForm.php'>Login here</a>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Evaluation</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray for background */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* Form container styling */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            width: 100%;
            max-width: 600px;
        }

        /* Page heading styling */
        h1 {
            text-align: center;
            color: #333; /* Dark gray for heading */
            margin-bottom: 20px;
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Textarea and select field styling */
        textarea,
        select,
        input[type="file"] {
            width: 100%; /* Full width for better usability */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px;
            font-size: 14px; /* Standard font size */
        }

        /* Submit and logout button styling */
        button {
            width: 100%; /* Full-width button */
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer; /* Pointer cursor for buttons */
        }

        button[type="submit"] {
            background-color: #28a745; /* Green button for submit */
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Logout button styling */
        .logout-btn {
            background-color: #007BFF; /* Blue button for logout */
            color: white;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Page heading -->
        <h1>Request Evaluation</h1>

        <!-- Form to submit an evaluation request -->
        <form action="processEvaluationRequest.php" method="POST" enctype="multipart/form-data">
            <!-- Input for object details -->
            <label for="details">Object Details:</label>
            <textarea id="details" name="details" required></textarea>

            <!-- Dropdown for contact method -->
            <label for="contactMethod">Preferred Contact Method:</label>
            <select id="contactMethod" name="contactMethod" required>
                <option value="email">Email</option>
                <option value="phone">Phone</option>
            </select>

            <!-- File input for photo upload -->
            <label for="photo">Upload Photo (JPG, PNG, GIF | Max: 2MB):</label>
            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.gif" required>

            <!-- Submit button to send the request -->
            <button type="submit">Submit Request</button>
        </form>

        <!-- Form to log out of the session -->
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>

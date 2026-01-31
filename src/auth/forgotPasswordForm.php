<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full screen height */
            margin: 0;
        }

        /* Styling for the form container */
        .form-container {
            background: #fff; /* White background for contrast */
            padding: 20px;
            border-radius: 8px; /* Smooth rounded edges */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
            max-width: 400px;
            width: 100%;
        }

        /* Centered heading for the form */
        h2 {
            text-align: center;
            color: #333; /* Dark text for readability */
            margin-bottom: 20px;
        }

        /* Labels and input fields styling */
        label {
            font-weight: bold; /* Make labels stand out */
            margin-bottom: 5px;
            display: block;
        }

        input[type="email"] {
            width: 100%; /* Full width for better usability */
            padding: 10px;
            margin-bottom: 20px; /* Space between fields */
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px; /* Rounded edges for modern design */
            font-size: 14px; /* Standard font size */
        }

        /* Submit button styling */
        input[type="submit"] {
            width: 100%; /* Full width button */
            padding: 10px;
            background-color: #007BFF; /* Bright blue button */
            color: white; /* White text on blue button */
            border: none;
            border-radius: 4px; /* Smooth edges */
            font-size: 16px;
            cursor: pointer; /* Pointer cursor for interactivity */
        }

        /* Hover effect for the button */
        input[type="submit"]:hover {
            background-color: #0056b3; /* Slightly darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password</h2>
        <!-- Form to handle password recovery via email -->
        <form action="forgotPasswordSecurityQuestion.php" method="POST">
            <!-- Input field for the user's email -->
            <label for="txtEmail">Email:</label>
            <input name="txtEmail" id="txtEmail" type="email" required />

            <!-- Submit button to proceed with password recovery -->
            <input type="submit" value="Submit" />
        </form>
    </div>
</body>
</html>

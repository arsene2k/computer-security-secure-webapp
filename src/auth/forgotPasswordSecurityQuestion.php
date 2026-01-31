<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the email input to prevent XSS or injection attacks
    $email = htmlspecialchars($_POST['txtEmail']);

    // Establish a connection to the database
    $conn = new mysqli("localhost", "root", "", "MyCustomDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a query to fetch the security question for the provided email
    $stmt = $conn->prepare("SELECT SecurityQuestion FROM SystemUser WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the security question
        $row = $result->fetch_assoc();
        $securityQuestion = $row['SecurityQuestion'];

        // Render the form to answer the security question
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Security Question</title>";
        echo "<style>
                /* General styling */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f8f9fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                /* Form container styling */
                .form-container {
                    background: #fff;
                    padding: 20px 30px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 400px;
                    text-align: center;
                }

                /* Label and text styling */
                label {
                    font-weight: bold;
                    margin-bottom: 10px;
                    display: block;
                }

                /* Input field styling */
                input[type='text'] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 20px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }

                /* Submit button styling */
                input[type='submit'] {
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    background-color: #007BFF;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                input[type='submit']:hover {
                    background-color: #0056b3;
                }
            </style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='form-container'>";
        echo "<h2>Answer Security Question</h2>";
        echo "<form action='processSecurityAnswer.php' method='POST'>";
        echo "<label>Security Question:</label>";
        echo "<p>" . htmlspecialchars($securityQuestion) . "</p>";
        echo "<input type='hidden' name='email' value='" . htmlspecialchars($email) . "' />";
        echo "<label for='securityAnswer'>Answer:</label>";
        echo "<input name='securityAnswer' type='text' required />";
        echo "<input type='submit' value='Submit' />";
        echo "</form>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        // If no matching email is found, display an error
        echo "<div style='font-family: Arial, sans-serif; background-color: #f8d7da; color: #842029; padding: 20px; border-radius: 5px; max-width: 400px; margin: 50px auto; text-align: center;'>
                Email not found.
              </div>";
    }

    // Close database connections
    $stmt->close();
    $conn->close();
}
?>

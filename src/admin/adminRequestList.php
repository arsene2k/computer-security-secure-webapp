<?php
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You must be an admin to view this page.");
}

// Establish a database connection
$conn = new mysqli("localhost", "root", "", "MyCustomDB");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all evaluation requests from the database
$sql = "SELECT ID, UserEmail, Details, ContactMethod, PhotoPath, CreatedAt FROM EvaluationRequests ORDER BY CreatedAt DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Evaluation Requests</title>
    <style>
        /* General styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray for a clean look */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* Container for the content */
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            width: 100%;
            max-width: 900px;
        }

        /* Page title */
        h1 {
            text-align: center;
            color: #333; /* Dark gray for readability */
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%; /* Full-width table */
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd; /* Light gray borders */
        }

        table th {
            background-color: #007BFF; /* Blue background for headers */
            color: white; /* White text for contrast */
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9; /* Slightly shaded rows for better readability */
        }

        table tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }

        /* Logout button styling */
        .logout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF; /* Blue button */
            color: white; /* White text for contrast */
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Evaluation Requests</h1>
        <!-- Table displaying the evaluation requests -->
        <table>
            <tr>
                <th>ID</th>
                <th>User Email</th>
                <th>Details</th>
                <th>Contact Method</th>
                <th>Photo</th>
                <th>Request Date</th>
            </tr>
            <?php
            // Check if there are any evaluation requests and display them
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['UserEmail']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Details']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ContactMethod']) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row['PhotoPath']) . "' target='_blank'>View Photo</a></td>";
                    echo "<td>" . htmlspecialchars($row['CreatedAt']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no evaluation requests are found, display a message
                echo "<tr><td colspan='6'>No requests found.</td></tr>";
            }
            ?>
        </table>
        <!-- Logout button to end the admin session -->
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection after processing
$conn->close();
?>

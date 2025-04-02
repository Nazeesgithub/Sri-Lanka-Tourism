<?php
// Database connection
$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "sri_lanka_tourism";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$feedback_submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedback_text = $conn->real_escape_string($_POST['feedback']);
    $submission_date = date("Y-m-d H:i:s"); 

    // Inserting query to save feedback into the database
    $sql = "INSERT INTO feedback (full_name, email, feedback_text, submission_date) 
            VALUES ('$full_name', '$email', '$feedback_text', '$submission_date')";

    if ($conn->query($sql) === TRUE) {
        $feedback_submitted = true; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .message-container {
            margin-top: 100px;
        }
        .thank-you-message {
            color: #2d572c;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <?php if ($feedback_submitted): ?>
            <p class="thank-you-message">Thank you for your feedback!</p>
            <a href="index.html" class="back-link">Back to Home</a>
        <?php else: ?>
            <p class="thank-you-message" style="color: red;">There was an issue submitting your feedback. Please try again later.</p>
            <a href="index.html" class="back-link">Back to Home</a>
        <?php endif; ?>
    </div>
</body>
</html>





<?php
// Database connection details
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "sri_lanka_tourism"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to hold the message to display in the modal
$success = false; // Track whether the submission is successful

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $packages = $conn->real_escape_string($_POST['packages']);
    $messageText = $conn->real_escape_string($_POST['message']);
    $startDate = $conn->real_escape_string($_POST['startDate']);
    $endDate = $conn->real_escape_string($_POST['endDate']);

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO enquiries (fullname, email, phone, packages, message, strtdate, enddate) 
            VALUES ('$fullName', '$email', '$phone', '$packages', '$messageText', '$startDate', '$endDate')";

    // Execute query and set message for modal
    if ($conn->query($sql) === TRUE) {
        $message = "Thank you for your enquiry! We will get back to you shortly.";
        $success = true; //initialized varibales used here 
    } else {
        $message = "Error: Unable to process your enquiry. Please try again later.";
        $success = false;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Modal background */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: <?php echo $message ? 'flex' : 'none'; ?>;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Modal box */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Message style */
        .modal-message {
            font-size: 18px;
            color: <?php echo $success ? 'black' : 'red'; ?>;
            margin-bottom: 20px;
        }

        /* Close button */
        .close-button {
            display: inline-block;
            padding: 10px 20px;
            background-color:get_parent_class;
            color: get_parent_class;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .close-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php if ($message): ?>
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-message"><?php echo $message; ?></div>
            <a href="enquiry.html" class="close-button">Close</a>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>







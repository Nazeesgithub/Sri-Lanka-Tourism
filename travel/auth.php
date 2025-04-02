<?php
// Database connection parameters
$host = "localhost";
$dbname = "travelandtourism";
$username = "root";
$password = "";

// Initialize feedback variables for modals or redirects
$message = "";
$success = false;

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}

// Process form submissions for signup or signin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        // Sign-up logic
        $fullName = htmlspecialchars($_POST['full-name'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

        try {
            // Insert new user into `users` table
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$fullName, $email, $password]);

            // Redirect to signin page after successful signup
            header("Location: signin.html?signup_success=1");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "Email already exists. Please use a different email.";
            } else {
                $message = "Error: " . $e->getMessage();
            }
            $success = false;
        }
    } elseif (isset($_POST['signin'])) {
        // Sign-in logic
        $email = htmlspecialchars($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Fetch user details from the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $message = "Sign-in successful! Welcome back.";
            $success = true;
            // You can set a session or redirect to the homepage here
            header("Location: index.html"); // Redirect after successful sign-in
            exit();
        } else {
            // Failed login
            $message = "Invalid email or password. Please try again.";
            $success = false;
        }
    }
}

// Redirect back to the signup or signin page with feedback
if (!$success) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?message=" . urlencode($message));
    exit();
}
?>


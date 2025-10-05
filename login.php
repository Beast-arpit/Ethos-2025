<?php
// Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "db.php"; // Your PDO database connection

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment_no = trim($_POST['enrollment_no']);
    $password = $_POST['password'];

    try {
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT pass, email FROM enrollment WHERE enrollment_no = ?");
        $stmt->execute([$enrollment_no]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pass'])) {
            // Login successful
            $_SESSION['enrollment_no'] = $enrollment_no;
            $_SESSION['email'] = $user['email'];

            // Redirect to Student Portal
            header("Location: studentpage.php"); // Change to studentpage.php for security
            exit();
        } else {
            $login_error = "❌ Invalid enrollment number or password";
        }
    } catch (PDOException $e) {
        $login_error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Login</title>
    <link rel="stylesheet" href="loginpage.css">
    <style>
        .error-msg { color: red; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body class="body">
    
    <div class="login-container">
        <h1 class="title">STUDENT/STAFF LOGIN</h1>

        <?php if($login_error): ?>
            <p class="error-msg"><?= htmlspecialchars($login_error) ?></p>
        <?php endif; ?>

        <form method="POST" class="form-box">
            <div class="form-group">
                <label for="enrollment_no">Enrollment No:</label>
                <input type="text" id="enrollment_no" name="enrollment_no" placeholder="e.g., B21012345" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="submit-btn">Login</button>
        </form>

        <p><a href="enroll.php">Go to Enrollment</a></p>
        <p><a href="view.php">View Enrollments</a></p>
    </div>
    
</body>
</html>

<?php include "db.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment_no = $_POST['enrollment_no'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO table1 (enrollment_no, email, pass) VALUES (?, ?, ?)");
    $stmt->execute([$enrollment_no, $email, $password]);
    echo "<p style='color:green'>✅ Enrollment successful!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enroll</title>
</head>
<body>
    <h2>Enrollment Form</h2>
    <form method="POST">
        Enrollment No: <input type="text" name="enrollment_no" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Enroll</button>
    </form>

    <p><a href="login.php">Go to Login</a></p>
    <p><a href="view.php">View Enrollments</a></p>
</body>
</html>

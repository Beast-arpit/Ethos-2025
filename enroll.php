<?php
// === DEBUG MODE (optional) ===
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php'; // Make sure $pdo is defined here

$error = '';

// === CSV folder setup ===
$csvFolder = __DIR__ . '/csv'; // Saves CSV in 'csv' folder inside project
if (!is_dir($csvFolder)) {
    mkdir($csvFolder, 0777, true); // Create folder if it doesn't exist
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment_no = trim($_POST['enrollment_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_raw = trim($_POST['password'] ?? '');

    // === Validate inputs ===
    if ($enrollment_no === '' || $email === '' || $password_raw === '') {
        $error = "Please fill all required fields.";
    } else {
        $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

        try {
            // === 1️⃣ Save to MySQL ===
            $stmt = $pdo->prepare(
                "INSERT INTO enrollment (enrollment_no, email, pass, created_at) VALUES (?, ?, ?, NOW())"
            );
            $stmt->execute([$enrollment_no, $email, $password_hashed]);

            // === 2️⃣ Save to CSV ===
            $file = $csvFolder . '/enrollment_data.csv';
            $data = [$enrollment_no, $email, $password_hashed, date('Y-m-d H:i:s')];

            $is_new = !file_exists($file);
            $fp = fopen($file, 'a');
            if (!$fp) {
                die("Cannot open CSV file. Check folder permissions!");
            }
            if ($is_new) {
                fputcsv($fp, ['Enrollment No', 'Email', 'Password (Hashed)', 'Created At']);
            }
            fputcsv($fp, $data);
            fclose($fp);

            // === 3️⃣ Success message & redirect ===
            echo "<script>
                    alert('Enrollment successful!');
                    window.location.href='login.php';
                  </script>";
            exit();

        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Enrollment</title>
<link rel="stylesheet" href="enroll.css">
</head>
<body>
<div class="container">
    <h2>Student Enrollment</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="enroll-form">
        <label>Enrollment No:</label>
        <input type="text" name="enrollment_no" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
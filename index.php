<?php
// Any PHP code you need (e.g., session start, includes) can stay here
// session_start();
// include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collytics - Home</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>

    <!-- Header -->
    <header class="header">
        <!-- Logo removed -->
        <div class="header-text">
            <h1>Collytics</h1>
            <h3>Know it, Report it, Stop it: Student Security</h3>
        </div>
    </header>

    <!-- Portal Options -->
    <main class="portal-container">
        <section class="portal-box student-box">
            <h2>Student Portal</h2>
            <img src="graduating-student.png" alt="Graduating student icon">
            <p>Access the student portal to report issues and stay informed.</p>
            <a href="login.php" class="portal-access">Access</a>
        </section>

        <section class="portal-box staff-box">
            <h2>Staff Portal</h2>
            <img src="teacher.png" alt="Staff icon">
            <p>Staff members can manage reports and monitor student security.</p>
            <a href="/login.php" class="portal-access">Access</a>
        </section>
    </main>

</body>
</html>

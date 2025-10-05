<?php
session_start();

// Optional: check if staff/admin is logged in
if (!isset($_SESSION['staff_logged_in'])) {
    // redirect to login if needed
    // header("Location: staff_login.php");
    // exit();
}

include "db.php"; // connect to database

try {
    // Fetch all location records from student_locations table
    $stmt = $pdo->prepare("SELECT enrollment_no, latitude, longitude, status, created_at FROM student_locations ORDER BY created_at DESC");
    $stmt->execute();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Student Locations</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 900px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #e8f5e9;
    }
</style>
</head>
<body>

<h1>Student Location Records</h1>

<table>
    <tr>
        <th>Enrollment No</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Status</th>
        <th>Recorded At</th>
    </tr>

    <?php if($locations): ?>
        <?php foreach($locations as $loc): ?>
            <tr>
                <td><?= htmlspecialchars($loc['enrollment_no']) ?></td>
                <td><?= htmlspecialchars($loc['latitude']) ?></td>
                <td><?= htmlspecialchars($loc['longitude']) ?></td>
                <td><?= htmlspecialchars($loc['status']) ?></td>
                <td><?= htmlspecialchars($loc['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No location records found.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>

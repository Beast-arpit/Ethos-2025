<?php
include "db.php"; // your database connection

$enrollment_no = $_POST['enrollment_no'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$status = $_POST['status'] ?? '';

// Simple validation
if (!$enrollment_no || !$latitude || !$longitude) {
    echo "Missing required data!";
    exit();
}

try {
    // Check the most recent entry for this enrollment
    $stmt = $pdo->prepare("SELECT created_at FROM student_locations WHERE enrollment_no = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$enrollment_no]);
    $lastEntry = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentTime = new DateTime(); // current server time

    if ($lastEntry) {
        $lastSaved = new DateTime($lastEntry['created_at']);
        $diffSeconds = $currentTime->getTimestamp() - $lastSaved->getTimestamp();

        if ($diffSeconds < 10) {
            // If last save was less than 10 seconds ago, consider it recently saved
            echo "Location already saved at " . $lastSaved->format('h:i:s A');
            exit();
        }
    }

    // Save new location
    $stmt = $pdo->prepare("INSERT INTO student_locations (enrollment_no, latitude, longitude, status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$enrollment_no, $latitude, $longitude, $status]);

    echo "Location saved at " . $currentTime->format('h:i:s A'); // 12-hour format with AM/PM

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

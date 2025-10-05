<?php
include "db.php";

$enrollment_no = $_POST['enrollment_no'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$status = $_POST['status'] ?? '';

if (!$enrollment_no || !$latitude || !$longitude) {
    echo "Missing required data!";
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO student_locations (enrollment_no, latitude, longitude, status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$enrollment_no, $latitude, $longitude, $status]);

    echo "Location saved at " . date('h:i:s A');
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

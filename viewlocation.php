<?php
// Start session if needed
// session_start();

include "db.php"; // Make sure this connects to database `website1`

try {
    // Fetch all location records, newest first
    $stmt = $pdo->query("SELECT enrollment_no, latitude, longitude, status, created_at FROM student_locations ORDER BY created_at DESC");
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
<title>All Students Location History</title>
<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f0f0f0; }
    h1 { text-align: center; margin-bottom: 30px; }
    table { border-collapse: collapse; width: 100%; max-width: 1000px; margin: auto; background: white; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #4CAF50; color: white; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    tr:hover { background-color: #d0f0d0; }
</style>
</head>
<body>

<h1>All Students Location History</h1>

<table>
    <tr>
        <th>Enrollment No</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Status</th>
        <th>Saved At</th>
    </tr>
    <?php if($locations): ?>
        <?php foreach($locations as $loc): ?>
            <tr>
                <td><?php echo htmlspecialchars($loc['enrollment_no']); ?></td>
                <td><?php echo htmlspecialchars($loc['latitude']); ?></td>
                <td><?php echo htmlspecialchars($loc['longitude']); ?></td>
                <td><?php echo htmlspecialchars($loc['status']); ?></td>
                <td><?php echo date("h:i:s A, d M Y", strtotime($loc['created_at'])); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No location data found.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>

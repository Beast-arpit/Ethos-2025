<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['enrollment_no'])) {
    header("Location: login.php");
    exit();
}

$enrollment_no = $_SESSION['enrollment_no'];
$email = $_SESSION['email'] ?? 'unknown@example.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Portal</title>
<link rel="stylesheet" href="Studentpage.css">
<link rel="stylesheet" href="currentstatus.css">
</head>
<body>

<div class="welcome-banner">
Welcome, <?php echo htmlspecialchars($email); ?> (Enrollment: <?php echo htmlspecialchars($enrollment_no); ?>)
</div>

<div class="current-location">
<h2>Current Location</h2>
<p>Latitude: <span id="latitude">N/A</span></p>
<p>Longitude: <span id="longitude">N/A</span></p>
<p id="status">Click "Start Tracking" to begin saving your location.</p>
<button onclick="startTracking()">Start Tracking</button>
<button onclick="stopTracking()">Stop Tracking</button>
<button onclick="clearPreviousData()">Clear Data</button>
</div>

<div class="status-container">
<h2>Submit Your Status</h2>
<select id="status-input">
    <option value="" disabled selected>Select your status</option>
    <option>Available on Campus</option>
    <option>In Transit (On-Campus)</option>
    <option>Off-Campus (Commuting)</option>
    <option>Off-Campus (Personal Time)</option>
    <option>Emergency - Need Assistance</option>
    <option>Check-In Complete (Safe)</option>
</select>
<button onclick="submitStatus()">Submit</button>

<p id="lastUpdateInfo">Last Status Update: Never</p>
<p id="checkerStatus">Checker: Waiting</p>
<div id="status-feed"></div>
</div>

<script>
const enrollmentNo = "<?php echo $enrollment_no; ?>";
const userEmail = "<?php echo $email; ?>";
</script>

<script src="student_alert.js"></script>
</body>
</html>

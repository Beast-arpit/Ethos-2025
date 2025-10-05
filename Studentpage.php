<?php
session_start();
if (!isset($_SESSION['enrollment_no'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student-Portal</title>
<link rel="stylesheet" href="Studentpage.css">
</head>
<body style="background-image: url('background.jpg');">

<div class="title-box">
    <h1>Student-Portal</h1>
</div>

<!-- Location Tracking Section -->
<div class="current-location">
    <h2>Current Location</h2>

    <p>Latitude: <span id="latitude">N/A</span></p>
    <p>Longitude: <span id="longitude">N/A</span></p>

    <label for="current-status">Current Status:</label>
    <input type="text" id="current-status" placeholder="Enter your status"><br><br>

    <button type="button" onclick="getLiveLocation()">Add Location</button>
    <button type="button" onclick="clearPreviousData()">Stop Tracking</button><br><br>

    <p id="status">Click "Add location" to start tracking.</p>
</div>

<!-- Comment Section -->
<div class="current-location">
    <h2>Post a Comment</h2>
    <form action="submit-comment.php" method="POST">
        <textarea id="comment" name="comment_body" rows="6" required></textarea><br><br>
        <button type="submit">Post Comment</button>
    </form>
</div>

<script>
let watchID = null;

function getLiveLocation() {
    const status = document.getElementById('status');
    if (!navigator.geolocation) {
        status.textContent = 'Geolocation is not supported by your browser';
        return;
    }
    status.textContent = 'Locating...';

    watchID = navigator.geolocation.watchPosition(success, error, {
        enableHighAccuracy: true,
        maximumAge: 0,
        timeout: 5000
    });
}

function success(position) {
    const latitudeSpan = document.getElementById('latitude');
    const longitudeSpan = document.getElementById('longitude');

    const latitude = position.coords.latitude.toFixed(6);
    const longitude = position.coords.longitude.toFixed(6);

    latitudeSpan.textContent = latitude;
    longitudeSpan.textContent = longitude;

    sendLocationToPHP(latitude, longitude);
}

function sendLocationToPHP(lat, lon) {
    const statusText = document.getElementById('current-status').value || '';
    const enrollmentNo = "<?php echo $_SESSION['enrollment_no']; ?>";

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_location.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('status').textContent = xhr.responseText;
        }
    };
    xhr.send(`enrollment_no=${enrollmentNo}&latitude=${lat}&longitude=${lon}&status=${statusText}`);
}

function error(err) {
    const statusSpan = document.getElementById('status');
    switch (err.code) {
        case err.PERMISSION_DENIED:
            statusSpan.textContent = "User denied the request for Geolocation.";
            break;
        case err.POSITION_UNAVAILABLE:
            statusSpan.textContent = "Location information is unavailable.";
            break;
        case err.TIMEOUT:
            statusSpan.textContent = "The request to get user location timed out.";
            break;
        default:
            statusSpan.textContent = "An unknown error occurred.";
            break;
    }
    if (watchID != null) navigator.geolocation.clearWatch(watchID);
}

function clearPreviousData() {
    document.getElementById('latitude').textContent = 'N/A';
    document.getElementById('longitude').textContent = 'N/A';
    document.getElementById('status').textContent = 'Data cleared.';
    if (watchID != null) navigator.geolocation.clearWatch(watchID);
}
</script>

</body>
</html>

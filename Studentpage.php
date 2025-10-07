<?php
session_start();
if(!isset($_SESSION['enrollment_no'])) {
    header("Location: login.php");
    exit();
}
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
    <div class="title-box">
        <h1>Student Portal</h1>
    </div>

    <div class="current-location">
        <h2>Current Location</h2>
        <p>Latitude: <span id="latitude">N/A</span></p>
        <p>Longitude: <span id="longitude">N/A</span></p>
        <p id="status">Click "Start Tracking" to begin saving your location.</p>

        <button type="button" onclick="startTracking()">Start Tracking</button>
        <button type="button" onclick="stopTracking()">Stop Tracking</button>
        <button type="button" onclick="clearPreviousData()">Clear Data</button>
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
        <div id="status-feed"></div>
        
    </div>

    <!-- Pass PHP session to JS -->
    <script>
        const enrollmentNo = "<?php echo $_SESSION['enrollment_no']; ?>";
    </script>
    <script>
        document.getElementbyId("submitStatus").onclick = function() {
            const status = document.getElementById("status-input").value;
            if (status === "Emergency - Need Assistance") {
                fetch('https://your-api-endpoint/sendemail', {
                    method: 'POST', 
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        to: 'singharpit29416@gmail.com',
                        subject: 'Emergency Alert: Student Needs Assistance',
                        message: 'A student has reported an emergency and needs assistance. Please check the portal for details. '
                        studentId: enrollmentNo
                    })
                })
                .then(response => resopnse.json())
                .then(data => {
                    alert('Emergency notification sent succesfully.');
                })
                .catch(error => {
                    console.error('Error sending email:', error);
                    alert('Failed to send emergency notification.');
                });

            } else if (status && status !== "select your status") {
                alert('Thankyou for submitting your current status.');
            }
        }
    </script>
    <script src="location.js"></script>
    <script src="Student_alert.js"></script>
    <script src="studentpage.js"></script>
</body>
</html>

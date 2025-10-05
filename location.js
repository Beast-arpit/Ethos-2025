function getLiveLocation() {
    const status = document.getElementById('status');

    if (!navigator.geolocation) {
        status.textContent = 'Geolocation is not supported by your browser';
        return;
    }

    status.textContent = 'Getting location...';

    navigator.geolocation.getCurrentPosition(success, error, {
        enableHighAccuracy: true,
        timeout: 5000
    });
}

function success(position) {
    const latitude = position.coords.latitude.toFixed(6);
    const longitude = position.coords.longitude.toFixed(6);

    document.getElementById('latitude').textContent = latitude;
    document.getElementById('longitude').textContent = longitude;

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
    xhr.send(`enrollment_no=${enrollmentNo}&latitude=${lat}&longitude=${lon}&status=${encodeURIComponent(statusText)}`);
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
}

function clearPreviousData() {
    document.getElementById('latitude').textContent = 'N/A';
    document.getElementById('longitude').textContent = 'N/A';
    document.getElementById('status').textContent = 'Data cleared.';
}

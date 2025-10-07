// === Status Checker & Timer ===
const LAST_UPDATE_KEY = 'lastStatusUpdateTimestamp';
const OVERDUE_LIMIT_MS = 21600000; // 6 hours
const CHECKER_FREQUENCY_MS = 300000; // 5 minutes
let checkerInterval;

function checkForStatusOverdue() {
    const lastUpdate = localStorage.getItem(LAST_UPDATE_KEY);
    const info = document.getElementById('lastUpdateInfo');
    const checker = document.getElementById('checkerStatus');

    if (!lastUpdate) {
        info.textContent = 'Last Status Update: Never. Please update status.';
        checker.textContent = "Checker: Waiting";
        return;
    }

    const elapsed = Date.now() - parseInt(lastUpdate);
    info.textContent = `Last Status Update: ${new Date(parseInt(lastUpdate)).toLocaleString()}`;

    if (elapsed >= OVERDUE_LIMIT_MS) {
        alert(`❌ Status overdue! ${(elapsed/3600000).toFixed(2)} hours passed`);
        checker.textContent = "ERROR: STATUS OVERDUE!";
    } else {
        const remainingH = ((OVERDUE_LIMIT_MS - elapsed)/3600000).toFixed(2);
        checker.textContent = `Checker: OK. Time left: ${remainingH} hours`;
    }
}

function startChecker() {
    if (checkerInterval) clearInterval(checkerInterval);
    checkerInterval = setInterval(checkForStatusOverdue, CHECKER_FREQUENCY_MS);
    checkForStatusOverdue();
}

function stopChecker() {
    if (checkerInterval) clearInterval(checkerInterval);
    document.getElementById('checkerStatus').textContent = "Checker: Stopped";
}

// === Submit Status ===
function submitStatus() {
    const status = document.getElementById('status-input').value;
    if (!status) { alert("Select a status"); return; }

    const latitude = document.getElementById('latitude').textContent;
    const longitude = document.getElementById('longitude').textContent;

    fetch('savestatus.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            enrollment_no: enrollmentNo,
            email: userEmail,
            status: status,
            latitude: latitude,
            longitude: longitude
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ Status saved!");
            document.getElementById('status-feed').innerHTML += `<p>${status} - ${new Date().toLocaleString()}</p>`;
            localStorage.setItem(LAST_UPDATE_KEY, Date.now());
            checkForStatusOverdue();
        } else {
            alert("❌ Failed: " + (data.message||'Unknown'));
        }
    })
    .catch(err => {
        console.error(err);
        alert("❌ Error sending data");
    });
}

// === Location Tracking ===
let watchID;
function startTracking() {
    if (navigator.geolocation) {
        watchID = navigator.geolocation.watchPosition(
            pos => {
                document.getElementById('latitude').textContent = pos.coords.latitude;
                document.getElementById('longitude').textContent = pos.coords.longitude;
            },
            err => { alert('Error getting location: ' + err.message); },
            { enableHighAccuracy: true }
        );
    } else {
        alert("Geolocation not supported");
    }
}

function stopTracking() {
    if (watchID) navigator.geolocation.clearWatch(watchID);
}

function clearPreviousData() {
    document.getElementById('latitude').textContent = 'N/A';
    document.getElementById('longitude').textContent = 'N/A';
}

document.addEventListener('DOMContentLoaded', startChecker);

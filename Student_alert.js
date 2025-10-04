const LAST_UPDATA_KEY = 'lastStatusUpdateTimestamp';

const OVERDUE_LIMIT_MS = 21600000;

const CHECKER_FREQUENCY_MS = 300000;

let checkerInterval;


function checkForStatusOverdue() {
    const lastUpdate = localStorage.getItem(LAST_UPDATA_KEY);
    const currentTime = Date.now();
    const infoElement = document.getElementById('lastUpdateInfo');

    if(!lastUpdateTimestamp) {
        infoElement.textContent = 'Last Status Update: Never. Please update status to begin tracking.';
        return;
    }

    const timeElapsed = currentTime - parseInt(lastUpdateTimestamp);
    const hoursPassed = timeElapsed / 3600000;

    infoElement.textContent = `Last Status Update: ${new Date(parseInt(lastUpdateTimestamp)).toLocaleString()}`;

    if (timeElapsed >= OVERDUE_LIMIT_MS) {
        alert(`❌ ERROR: Status Update Overdue! It has been ${hoursPassed.toFixed(2)} hours without an update. System requires immediate status confirmation.`);
        document.getElementById('checkerStatus').textContent = "ERROR: STATUS OVERDUE!";
    } else {
        const remainingTime = OVERDUE_LIMIT_MS - timeElapsed;
        const remainingHours = (remainingTime / 3600000).toFixed(2);
        document.getElementById('checkerStatus').textContent = `Checker: OK. Time left: ${remainingHours} hours.`;
    }
}

function updateStatus() {
    const currentTime = Date.now();

    localStorage.setItem(LAST_UPDATA_KEY, currentTime);

    alert('✅ Status updated successfully. Timer reset for 6 hours');

    checkForStatusOverdue();

}

function startChecker() {
    if (checkerInterval) {
        clearInterval(checkerInterval);
    }

    checkerInterval = setInterval(checkForStatusOverdue, CHECKER_FREQUENCY_MS);
    document.getElementById('checkerStatus').textContent = "Checker: Active";

    checkForStatusOverdue();
}

function stopChecker() {
    if (checkerInterval) {
        clearInterval(checkerInterval);
        document.getElementById('checkerStatus').textContent = "Checker: Stopped";

    }
}

document.addEventListener('DOMContentLoaded', startChecker);


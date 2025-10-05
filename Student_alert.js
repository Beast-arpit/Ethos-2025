const TWELVE_HOURS = 12 * 60 * 60 * 1000; // 12 hours in milliseconds

    window.onload = function () {
      checkStatusReminder();
    };

    function checkStatusReminder() {
      const lastSubmitted = localStorage.getItem('lastSubmittedTime');
      const now = new Date().getTime();

      if (!lastSubmitted) {
        // No status ever submitted
        alert("You haven't submitted a status yet. Please update your status.");
      } else if (now - lastSubmitted > TWELVE_HOURS) {
        // It's been more than 12 hours
        alert("You haven't updated your status in over 12 hours. Please update it.");
      }
    }

    function submitStatus() {
      const status = document.getElementById('statusInput').value.trim();

      if (status === "") {
        alert("Please enter a status before submitting.");
        return;
      }

      // Save the submission time
      localStorage.setItem('lastSubmittedTime', new Date().getTime());

      // Clear input
      document.getElementById('statusInput').value = "";

      // Show thank you notification
      const notification = document.getElementById('notification');
      notification.style.display = 'block';

      // Hide the notification after 3 seconds
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    }
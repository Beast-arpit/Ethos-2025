document.getElementById("submitStatus").onclick = function() {
    const status = document.getElementById("status-input").value;
    if (status === "Emergency - Need Assistance") {
        // Replace with your email API endpoint and payload
        fetch('https://localhost:3000/studentpage.php/send-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                to: 'singharpit29416@gmail.com', // recipient email
                subject: 'Emergency Alert: Student Needs Assistance',
                message: 'A student has reported an emergency and needs assistance. Please check the portal for details.',
                studentId: enrollmentNo // available from PHP session
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Emergency notification sent successfully.');
        })
        .catch(error => {
            console.error('Error sending email:', error);
            alert('Failed to send emergency notification.');
        });
    } else if (status && status !== "Select your status") {
        alert('Thank you for submitting your current status.');
    }
};

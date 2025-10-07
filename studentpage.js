document.getElementById("submitStatus").onclick = function() {
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
                message: 'A student has reported an emergency and needs assistance. Please check the portal for details.',
                studentId: enrollmentNo
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
    } else {
        alert('Please select a valid status.');
    }
};

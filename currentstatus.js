document.getElementById('submit-btn').addEventListener('click', function() {
            const statusSelect = document.getElementById('status-input');
            const statusContent = statusSelect.value;

            // Only proceed if the input is not empty
            if (statusContent) {
                // Get the current time and format it
                const now = new Date();
                const timestamp = now.toLocaleString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                });

                // Create a new post element
                const newPost = document.createElement('div');
                newPost.classList.add('status-post');
                
                // Add the status text
                newPost.innerHTML = `
                    ${statusContent}
                    <span class="timestamp">Posted: ${timestamp}</span>
                `;

                // Prepend the new post to the feed (newest at the top)
                const statusFeed = document.getElementById('status-feed');
                statusFeed.prepend(newPost);
                
                // Clear the input box after submission
                statusTextarea.value = '';
            } else {
                alert('Please enter a status before posting.');
            }
        });


// Get a reference to the form element
        const form = document.getElementById('status-container');
        const output = document.getElementById('output');

        // Add an event listener for the 'submit' event
        form.addEventListener('submit', function(event) {
            // 1. Prevent the default form submission (which would reload the page)
            event.preventDefault(); 
            
            // 2. Capture the initial data entered by the user
            const initialValue = document.getElementById('status-input').value;

            // 3. Show the prompt box and store the user's response
            // The prompt() function takes two arguments: 
            // - The message to display.
            // - An optional default value for the input field.
            const userPromptResponse = prompt("Thank you for submitting!\n\nPlease enter your name to confirm:", "Guest");

            // 4. Handle the user's response from the prompt
            if (userPromptResponse !== null) { // User clicked 'OK'
                output.textContent = `Submission Successful! Data: "${initialValue}" | Confirmed by: "${userPromptResponse}"`;
            } else { // User clicked 'Cancel' or closed the prompt
                output.textContent = `Submission was canceled in the prompt step. Initial Data: "${initialValue}"`;
            }
        });
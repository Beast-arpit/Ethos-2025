const form = document.getElementById('comment');

form.addEventListener('submit', function(event){
    event.preventDefault();

    const commentText = document.getElementById('comment').value.trim();

    if (commentText === ""){
        alert("Please eneter a comment before submitting.");
        return;
    }

    alert(" ✅ Comment submitted successful! have a good day 😊.");

    document.getElementById('comment').value = '';

});
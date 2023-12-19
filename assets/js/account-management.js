function validateForm() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;

    if (username.trim() === '' || email.trim() === '') {
        alert('Please fill in both the Username and Email fields.');
        return false; // Prevent form submission
    }

    // Add any additional validation logic here if needed

    return true; // Allow form submission
}
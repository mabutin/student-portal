function validateEmail(email) {
    const regex = /\S+@\S+\.\S+/;
    return regex.test(email);
}

function displayError(message) {
    const errorContainer = document.getElementById('errorContainer');
    errorContainer.textContent = message;
    errorContainer.classList.remove('hidden');
}
function validateAndDisplayError() {
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const username = usernameInput.value.trim();  // Trim to remove leading and trailing whitespaces
    const email = emailInput.value.trim();

    // Check if either username or email is empty
    if (username === '' || email === '') {
        displayError('Please enter both username and email.');
    } else if (!validateEmail(email)) {
        displayError('Invalid email format. Example: example@gmail.com');
    } else {
        // If all validations pass, you can clear or hide the error message
        const errorContainer = document.getElementById('errorContainer');
        errorContainer.textContent = '';
        errorContainer.classList.add('hidden');
        
        // Now, you can proceed with form submission or any other desired action
        document.forms[0].submit();  // Assuming the form is the first form on the page
    }
}
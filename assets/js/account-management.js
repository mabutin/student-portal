function validateEmail(email) {
    const regex = /\S+@\S+\.\S+/;
    return regex.test(email);
}

function displayError(message) {
    const errorContainer = document.getElementById('errorContainer');
    errorContainer.textContent = message;
    errorContainer.classList.remove('hidden');
}
const roles = [
    "Admin",
    "Admission",
    "Faculty",
    "College Registrar"
];

const genders = [
    "Female",
    "Male"
];
const relationship = [
    "Mother",
    "Father",
    "Grandmother",
    "Grandfather",
    "Aunt",
    "Child",
    "Sister",
    "Brother",
    "Wife",
    "Husband",
    "Uncle"
];

function populateSelect(selectId, options) {
    const selectElement = document.getElementById(selectId);

    if (!selectElement) {
        console.error(`Element with ID '${selectId}' not found.`);
        return;
    }

    options.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.text = option;
        selectElement.add(optionElement);
    });
}

document.addEventListener("DOMContentLoaded", function () {

    populateSelect("roleMenu", roles);
});

function validateForm() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;

    if (username.trim() === '' || email.trim() === '') {
        alert('Please fill in both the Username and Email fields.');
        return false; 
    }


    return true; 
}

function validateForm() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var messageDiv = document.getElementById('message');

    messageDiv.innerHTML = '';

    if (username.trim() === '' || email.trim() === '') {
        displayErrorMessage('Please fill in both the Username and Email fields.');
        return false;
    }

    if (/\s/.test(username) || !/^[a-zA-Z0-9_@]+$/.test(username)) {
        displayErrorMessage('Invalid username. Please use only letters, numbers, _, and @, and avoid spaces.');
        return false;
    }

    return true;
}

function validateForm() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;

    document.getElementById('message').innerHTML = '';

    if (username.trim() === '' || email.trim() === '') {
        displayErrorMessage('Please fill in both the Username and Email fields.');
        return false;
    }

    if (/\s/.test(username) || !/^[a-zA-Z0-9_@]+$/.test(username)) {
        displayErrorMessage('Invalid username. Please use only letters, numbers, _, and @, and avoid spaces.');
        return false;
    }

    return true;
}

function displayErrorMessage(message) {
    document.getElementById('message').innerHTML = '<div class="text-red-500 text-xs">' + message + '</div>';
}

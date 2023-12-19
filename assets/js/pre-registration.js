function validateEmail(email) {
    const regex = /\S+@\S+\.\S+/;
    return regex.test(email);
}

function displayError(message) {
    const errorContainer = document.getElementById('errorContainer');
    errorContainer.textContent = message;
    errorContainer.classList.remove('hidden');
}

function submitForm() {
    const emailInput = document.getElementById('email');
    const email = emailInput.value;

    if (!validateEmail(email)) {
        displayError('Invalid email format. Example: example@gmail.com');
        return false; 
    }

    const formData = new FormData(document.querySelector('form'));
    formData.append('submit', 'Submit');

    fetch('../php/pre-registration.php', {
        method: 'POST',
        body: new URLSearchParams(formData),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);

        if (data && data.status === 'recorded') {
            document.getElementById('studentNumber').textContent = data.studentNumber;
            document.getElementById('password').textContent = data.password;

            document.getElementById('popup').classList.remove('hidden');

            const blobData = new Blob(
                [`Student Number: ${data.studentNumber}\nPassword: ${data.password}`],
                { type: 'text/plain' }
            );

            const downloadLink = document.createElement('a');
            downloadLink.href = window.URL.createObjectURL(blobData);
            downloadLink.download = 'student_credentials.txt';

            downloadLink.click();

            window.URL.revokeObjectURL(downloadLink.href);
        } else {
            console.error('Unexpected server response:', data);
            displayError('Unexpected server response');
        }
    })
    .catch(error => {
        console.error('Error fetching or processing data:', error);
        displayError('Error fetching or processing data');
    });

    return false;
}

function goToLoginPage() {
    window.location.href = "../login/student/login.php";
}

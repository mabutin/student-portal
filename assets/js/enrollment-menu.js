const studentType = [
    "",
    "New Student",
    "Transferee",
    "Balik Aral",
    "Foreign Student"
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

    populateSelect("studentTypeMenu", studentType);
});

function updateForm() {
    const selectedStudentType = document.getElementById("studentTypeMenu").value;
    const enrollmentProcessText = document.getElementById("enrollmentProcessText");

    if (selectedStudentType === "New Student") {
        enrollmentProcessText.innerText = "You're applying for the first year and first semester.";
    } else if (selectedStudentType === "Transferee") {
        enrollmentProcessText.innerText = "You're applying as a transferee.";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    populateSelect("studentTypeMenu", studentType);
});


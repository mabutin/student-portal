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

    populateSelect("genderMenu", genders);
    populateSelect("relationshipMenu", relationship);
});

function calculateAge() {
    var birthDate = new Date(document.getElementById("birthDate").value);

    var currentDate = new Date();

    var age = currentDate.getFullYear() - birthDate.getFullYear();

    if (currentDate.getMonth() < birthDate.getMonth() || 
        (currentDate.getMonth() === birthDate.getMonth() && currentDate.getDate() < birthDate.getDate())) {
        age--;
    }

    document.getElementById("stdAge").value = age;
}
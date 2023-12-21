document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('profileDropdown');
    const dropdownContent = document.getElementById('profileDropdownContent');

    dropdownButton.addEventListener('click', function () {
        dropdownContent.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
            dropdownContent.classList.add('hidden');
        }
    });
});
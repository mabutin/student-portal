document.addEventListener('DOMContentLoaded', function () {
    var courseSelect = document.getElementById('course');
    var yearSelect = document.getElementById('year');
    var statusSelect = document.getElementById('status');

    function submitForm() {
        document.getElementById('filterForm').submit();
    }

    function clearFilters() {
        document.getElementById('course').value = '';
        document.getElementById('year').value = '';
        document.getElementById('status').value = '';
        submitForm();
    }

    courseSelect.addEventListener('change', submitForm);
    yearSelect.addEventListener('change', submitForm);
    statusSelect.addEventListener('change', submitForm);

    var clearFiltersButton = document.getElementById('clearFiltersButton');
    if (clearFiltersButton) {
        clearFiltersButton.addEventListener('click', clearFilters);
    }
});

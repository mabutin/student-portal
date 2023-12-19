function showTab(tabContentId, activeTabId, inactiveTabId) {
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('border-b-2', 'border-blue-200'));

    const activeTab = document.getElementById(activeTabId);
    const inactiveTab = document.getElementById(inactiveTabId);
    activeTab.classList.add('border-b-2', 'border-blue-200');
    inactiveTab.classList.remove('border-b-2', 'border-blue-200');

    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.add('hidden'));

    const tabContent = document.getElementById(tabContentId);
    tabContent.classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    const notificationTab = document.getElementById('notificationTab');
    const requestsTab = document.getElementById('requestsTab');
    const studentDetailsContainer = document.getElementById('studentDetailsContainer');

    notificationTab.addEventListener('click', function () {
        showTab('notificationTabContent', 'notificationTab', 'requestsTab');
    });

    requestsTab.addEventListener('click', function () {
        showTab('requestsTabContent', 'requestsTab', 'notificationTab');
    });

    const studentDetailsLinks = document.querySelectorAll('.student-details-link');
    const notificationTabContent = document.getElementById('notificationTabContent');
    const requestsTabContent = document.getElementById('requestsTabContent');

    studentDetailsLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            hideTabsAndContent();

            studentDetailsContainer.style.display = 'block';

            const studentId = this.getAttribute('data-student-id');

            loadStudentDetails(studentId);
        });
    });

    function loadStudentDetails(studentId) {
        notificationTabContent.innerHTML = '';
        requestsTabContent.innerHTML = '';

        fetch(`student-details.php?student_id=${studentId}`)
            .then(response => response.text())
            .then(data => {
                studentDetailsContainer.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

    function hideTabsAndContent() {
        notificationTab.classList.add('hidden');
        requestsTab.classList.add('hidden');

        notificationTabContent.classList.add('hidden');
        requestsTabContent.classList.add('hidden');
    }
});
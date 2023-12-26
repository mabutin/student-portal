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

function handleTabClick(tabId, contentId, otherTabId) {
    const tab = document.getElementById(tabId);
    const otherTab = document.getElementById(otherTabId);
    const tabContent = document.getElementById(contentId);

    tab.addEventListener('click', function () {
        showTab(contentId, tabId, otherTabId);
    });
}

function handleStudentDetailsLinks() {
    const studentDetailsLinks = document.querySelectorAll('.student-details-link');
    const studentDetailsContainer = document.getElementById('studentDetailsContainer');

    studentDetailsLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            hideTabsAndContent();

            studentDetailsContainer.style.display = 'block';

            const studentId = this.getAttribute('data-student-id');

            loadStudentDetails(studentId);
        });
    });
}

function loadStudentDetails(studentId) {
    const notificationTabContent = document.getElementById('notificationTabContent');
    const requestsTabContent = document.getElementById('requestsTabContent');

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
    const notificationTab = document.getElementById('notificationTab');
    const requestsTab = document.getElementById('requestsTab');
    const notificationTabContent = document.getElementById('notificationTabContent');
    const requestsTabContent = document.getElementById('requestsTabContent');

    notificationTab.classList.add('hidden');
    requestsTab.classList.add('hidden');

    notificationTabContent.classList.add('hidden');
    requestsTabContent.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    handleTabClick('notificationTab', 'notificationTabContent', 'requestsTab');
    handleTabClick('requestsTab', 'requestsTabContent', 'notificationTab');
    handleStudentDetailsLinks();
});

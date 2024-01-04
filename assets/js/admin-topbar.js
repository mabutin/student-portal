document.addEventListener('DOMContentLoaded', function () {
    const notificationsContainer = document.getElementById('notifications-container');
    const notificationCounter = document.querySelector('.notification-counter');

    function fetchNotifications() {

        fetch('your_notification_endpoint.php') 
            .then(response => response.json())
            .then(data => {
                updateNotificationsUI(data);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    function updateNotificationsUI(notifications) {
        notificationsContainer.innerHTML = '';

        if (notifications.length > 0) {
            notifications.forEach(notification => {
                const notificationDiv = document.createElement('div');
                notificationDiv.textContent = notification.message;

                const timestampDiv = document.createElement('div');
                timestampDiv.textContent = new Date(notification.datetime).toLocaleString();

                notificationsContainer.appendChild(notificationDiv);
                notificationsContainer.appendChild(timestampDiv);
                notificationsContainer.appendChild(document.createElement('hr'));
            });

            updateNotificationCounter(notifications.length);
        } else {
            const noNotificationsDiv = document.createElement('div');
            noNotificationsDiv.textContent = 'No new notifications';
            notificationsContainer.appendChild(noNotificationsDiv);

            updateNotificationCounter(0);
        }
    }

    function updateNotificationCounter(count) {
        notificationCounter.textContent = count;
    }

    const notificationButton = document.getElementById('notification-button');

    notificationButton.addEventListener('click', function () {
        notificationsContainer.classList.toggle('hidden');
        if (!notificationsContainer.classList.contains('hidden')) {
            fetchNotifications();
        }
    });

    document.addEventListener('click', function (event) {
        if (!notificationsContainer.contains(event.target) && !notificationButton.contains(event.target)) {
            notificationsContainer.classList.add('hidden');
        }
    });
});
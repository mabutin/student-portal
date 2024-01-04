document.addEventListener('DOMContentLoaded', function () {
    const notificationsContainer = document.getElementById('notifications-container');
    const notificationCounter = document.querySelector('.notification-counter');
    const notificationButton = document.getElementById('notification-button');

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

    // Set initial styles for the notification button
    notificationButton.addEventListener('click', function () {
        // Toggle the active state on click
        var isActive = !notificationButton.classList.contains('active');
        notificationButton.classList.toggle('active', isActive);

        // Change the fill color based on the active state
        var fillColor = isActive ? '#1d4ed8' : '#fff';
        notificationButton.querySelector('svg path').style.fill = fillColor;

        // Update the notification counter
        notificationCounter.style.backgroundColor = isActive ? '#1d4ed8' : 'transparent';
        notificationCounter.style.color = isActive ? '#fff' : '#1d4ed8';

        // Toggle the hidden class on the notifications container
        notificationsContainer.classList.toggle('hidden', !isActive);

        // Fetch notifications only when the button is active
        if (isActive) {
            fetchNotifications();
        }
    });

    document.addEventListener('click', function (event) {
        if (!notificationsContainer.contains(event.target) && !notificationButton.contains(event.target)) {
            // Reset the color of the notification button to the original state
            notificationButton.classList.remove('active');
            notificationButton.querySelector('svg path').style.fill = '#fff';

            // Hide the notifications container
            notificationsContainer.classList.add('hidden');
        }
    });
});

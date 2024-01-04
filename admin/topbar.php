<?php 

include '../php/conn.php';

$queryNotification = "SELECT * FROM notifications ORDER BY datetime DESC";
$resultNotification = mysqli_query($conn, $queryNotification);

if (!$resultNotification) {
    die("Query failed: " . mysqli_error($conn));
}

$notifications = mysqli_fetch_all($resultNotification, MYSQLI_ASSOC);

mysqli_free_result($resultNotification);

$groupedNotifications = [];
foreach ($notifications as $notification) {
    $date = date('Y-m-d', strtotime($notification['datetime']));
    $groupedNotifications[$date][] = $notification;
}

function formatDateHeading($datetime)
{
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $date = date('Y-m-d', strtotime($datetime));
    $time = date('g:i a', strtotime($datetime));

    if ($date === $today) {
        return 'Today, ' . $time;
    } elseif ($date === $yesterday) {
        return 'Yesterday, ' . $time;
    } else {
        return date('F j, Y, g:i a', strtotime($datetime));
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Topbar</title>
    
</head>

<body class="bg-gray-100">

    <?php
    date_default_timezone_set('Asia/Manila');
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $formattedUsername = ucfirst($username);

    function getGreeting()
    {
        $currentTime = date('H:i:s');
        $morningStart = '06:00:00';
        $afternoonStart = '12:00:00';
        $eveningStart = '18:00:00';

        if ($currentTime >= $morningStart && $currentTime < $afternoonStart) {
            return 'Good Morning!';
        } elseif ($currentTime >= $afternoonStart && $currentTime < $eveningStart) {
            return 'Good Afternoon!';
        } else {
            return 'Good Evening!';
        }
    }

    if (!empty($formattedUsername)) {
    ?>
        <div class="flex justify-between items-center max-w-screen pl-4">
            <div class="flex items-center gap-2">
                <div class="text-xl font-semibold">
                    <?php echo htmlspecialchars(getGreeting(), ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>


            <div class="flex items-center gap-4 relative">
                <div>
                    <div id="notifications-container" class="bg-white shadow-lg hidden fixed top-14 right-40 max-w-sm p-4 rounded-md border border-blue-300">
                        <div class="tex-base font-semibold">Notifications</div>
                        <?php if (!empty($groupedNotifications)) : ?>
                            <?php foreach ($groupedNotifications as $date => $dateNotifications) : ?>
                                <div class="font-semibold mt-2"><?= formatDateHeading($date) ?></div>
                                <?php foreach ($dateNotifications as $notification) : ?>
                                    <div><?= $notification['message']; ?></div>
                                    <div class="text-xs text-gray-500"><?= date('F j, Y, g:i a', strtotime($notification['datetime'])); ?></div>
                                    <hr class="my-2">
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div>No new notifications</div>
                        <?php endif; ?>
                    </div>
                    <button id="notification-button" class="flex items-center" type="button">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" onmouseover="this.style.fill='#1d4ed8';" onmouseout="this.style.fill='#fff';" style="stroke: #1d4ed8;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </span>
                        <span class="absolute -mt-4 ml-4 rounded-full p-1 text-xs font-medium leading-none notification-counter">1</span>
                    </button>
                </div>

                <img src="../assets/svg/profile.svg" alt="Profile Picture" class="w-8 h-8 rounded-full cursor-pointer" id="profileImage">
                <div class="relative group">
                    <button class="text-base font-semibold focus:outline-none">
                        <?php echo htmlspecialchars($formattedUsername, ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                    <div class="absolute hidden bg-white border shadow-md p-2 mt-2 rounded transform -translate-x-full group-hover:block max-w-xs ml-auto">
                        <a href="changepassword.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" style="white-space: nowrap;">Change password</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script src="../assets/js/dropdown.js"></script>
    <script src="../assets/js/admin-topbar.js"></script>
</body>

</html>
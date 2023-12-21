<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Topbar</title>
</head>

<body>
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
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="text-xl font-semibold">
                    <?php
                    echo htmlspecialchars(getGreeting(), ENT_QUOTES, 'UTF-8');
                    ?>
                </div>
            </div>
            <div class="inline-flex justify-between items-center gap-4">
                <div>
                    <div class="text-base font-semibold"><?php echo htmlspecialchars($formattedUsername, ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
                <img src="../assets/svg/profile.svg" alt="Profile Picture" class="w-8 h-8 rounded-full">
            </div>
        </div>
    <?php } ?>
</body>

</html>

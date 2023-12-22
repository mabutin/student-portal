<?php
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
<body>
    <form action="../login/student/logout.php" method="post">
        <div class="flex py-4 px-14 justify-between items-center">
            <div class="text-xl font-medium">
                <?php echo htmlspecialchars(getGreeting(), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="inline-flex justify-between items-center gap-4">
                <div class="relative">
                    <button id="profileDropdown" class="flex gap-2 items-center text-base hover:underline font-semibold focus:outline-none" type="button">
                        <div>
                            <?php echo htmlspecialchars($firstName . ' ' . $middleName . ' ' . $surname, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <div>
                            <?php if (empty($row['profile_picture'])): ?>
                                <img src="../assets/svg/profile.svg" class="w-10 h-10 mx-auto" alt="">
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($row['profile_picture']) ?>" class="w-10 h-10 mx-auto rounded-full" alt="">
                            <?php endif; ?>
                        </div>
                    </button>
                    <div id="profileDropdownContent" class="hidden absolute z-10 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">
                        <a href="student-profile.php" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Profile</a>
                        <a href="#" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="../assets/js/topbarStudent.js"></script>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'guest';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Faculty dashboard</title>
</head>

<body class="font-[roboto-serif]">
    <div class="flex justify-start">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
            <div>
                <?php
                if ($usertype === "developer" || $usertype === "Developer") {
                    echo '<p>Welcome, Developer!</p>';
                } elseif ($usertype === "admission" || $usertype === "Admission") {
                    echo '<p>Welcome, Admission User!</p>';
                } elseif ($usertype === "admin" || $usertype === "Admin") {
                    echo '<p>Welcome, Admin!</p>';
                } elseif ($usertype === "Faculty" || $usertype === "Faculty") {
                    echo '<p>Welcome, Faculty!</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
</body>

</html>

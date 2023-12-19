<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin dashboard</title>
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
                    if ($usertype == 'admin') {
                        echo '<p>Welcome, Admin!</p>';
                    } elseif ($usertype == 'admission') {
                        echo '<p>Welcome, Admission User!</p>';
                    } else {
                        echo '<p>Error: Unknown usertype</p>';
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js"></script>
</body>

</html>

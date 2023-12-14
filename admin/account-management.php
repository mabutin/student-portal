<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $insertQuery = "INSERT INTO usertbl (username, email, userType) VALUES ('$username', '$email', 'user')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        header('Location: success.php'); 
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

$selectQuery = "SELECT id, username, email, userType FROM usertbl";
$result = mysqli_query($conn, $selectQuery);

$users = [];
if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Account Management</title>
</head>
<body class="font-[roboto-serif]" style="background: rgba(118, 163, 224, 0.1);">
    <div class="flex justify-start">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div class="mb-4">
                <?php include './topbar.php'; ?>
            </div>
            <div class="w-full bg-white p-4 border border-blue-100 gap-2">
                <div>
                    Manage Accounts
                </div>
                <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                <div>
                    <form action="" method="post">
                        <div class="flex justify-start items-center gap-2 text-base">
                            <form action="" method="post">
                                <div class="flex justify-start items-center gap-2 text-base">
                                    <div>
                                        Username:
                                    </div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-64 text-xs">
                                        <input type="text" id="username" name="username" placeholder="Enter a username" class="px-1 w-full">
                                    </div>
                                    <div class="flex justfiy-start gap-2 items-center">
                                        <div>Email</div>
                                        <div class="w-64 text-sm p-1 border border-blue-200 rounded-md flex justify-between items-center relative gap-2">
                                            <input type="text" name="email" id="email" class="px-1 w-full" autocomplete="email" onblur="validateEmail()" placeholder="Enter email">
                                            <p id="emailError" class="text-red-500 hidden absolute top-full left-0 bg-white p-2 border border-red-500 rounded-md w-full">
                                                Invalid email format. Example: example@gmail.com
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Add user</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </form>
                    <div class="w-1/2 mt-4">
                        <div class="grid grid-cols-4 px-2" style="background: #8EAFDC;">
                            <div class="flex justify-center">ID</div>
                            <div class="flex justify-center">Username</div>
                            <div class="flex justify-center">Email</div>
                            <div class="flex justify-center">Role</div>
                        </div>
                        <?php foreach ($users as $index => $user): ?>
                            <div class="grid grid-cols-4 px-2 <?= $index % 2 === 0 ? 'bg-white-100' : '#9DBAE1' ?>">
                                <div class="flex justify-center"><?= $user['id']; ?></div>
                                <div class="flex justify-center"><?= $user['username']; ?></div>
                                <div class="flex justify-center"><?= $user['email']; ?></div>
                                <div class="flex justify-center"><?= $user['userType']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js"></script>
    <script src="../assets/js/account-management.js"></script>
</body>
</html>

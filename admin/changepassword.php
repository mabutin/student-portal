<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <div>
        <?php include './sidebar.php'; ?>
    </div>
    <div class="w-full py-4 px-4">
    <div class="mb-4">
        <?php include './topbar.php'; ?>
    </div>
    <script src="../assets/js/adminSidebar.js"></script>
</body>
</html>
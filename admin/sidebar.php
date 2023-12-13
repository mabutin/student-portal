<?php
session_start();

// Assuming you have stored user type in the session during login
$usertype = $_SESSION['usertype'];

// Function to check if the user has access based on user type
function hasAccess($allowedTypes, $userType) {
    return in_array($userType, $allowedTypes);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Admin System</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css">
</head>
<body>

    <div id="side-bar">
        <div id="logo">
            <img id="logo" src="ollclogo.svg" alt="School Logo">
        </div>
       <a href="#"><i class="fas fa-tachometer-alt"></i><span class="text">Dashboard</span></a>
       <a href=""> <i class="fas fa-address-book"></i><span class="text">New Enrollees</span></a>
       <a href=""> <i class="fas fa-graduation-cap"></i><span class="text">College</span></a>
        <a href="#"><i class="fas fa-user-graduate"></i><span class="text">Students</span></a>
        <a href=""> <i class="fas fa-book"></i><span class="text">Grades Report</span></a>
        <a href=""> <i class="fas fa-list-check"></i><span class="text">Student Requirements</span></a>
        <a href="#"><i class="fas fa-chalkboard-teacher"></i><span class="text">Faculty</span></a>
        <a href=""> <i class="fa-solid fa-calendar-days"></i><span class="text">School Calendar</span></a>
        <a href=""> <i></i><span class="text">School Essentials</span></a>
        <a href=""> <i class="fas fa-globe"></i><span class="text">School Website</span></a>
        <a href=""> <i class="fas fa-database"></i><span class="text">Data Management</span></a>


        <?php if (hasAccess(["admin"], $usertype)) : ?>
            <!-- Admin-specific sidebar links or content -->
            <a href="#"><i class="fas fa-tachometer-alt"></i><span class="text">Admin Dashboard</span></a>
            <!-- Add more links as needed -->
        <?php elseif (hasAccess(["admission"], $usertype)) : ?>
            <!-- Admission-specific sidebar links or content -->
            <a href="#"><i class="fas fa-address-book"></i><span class="text">New Enrollees</span></a>
            <!-- Add more links as needed -->
        <?php elseif (hasAccess(["dean"], $usertype)) : ?>
            <!-- Dean-specific sidebar links or content -->
            <a href="#"><i class="fas fa-book"></i><span class="text">Grades Report</span></a>
            <!-- Add more links as needed -->
        <?php else : ?>
            <!-- Default sidebar links or content for regular users -->
            <a href="#"><i class="fas fa-user-graduate"></i><span class="text">Students</span></a>
           
        <?php endif; ?>

        <br>
        <br>
        <a href="../login/admin/adminlog.php"><i class="fas fa-sign-out-alt"></i><span type="submit" name="logout" value="Logout">Logout</span></a>
    </div>

    

    <script>
        // JavaScript to toggle the sidebar
        const body = document.body;
        const sideBar = document.getElementById('side-bar');

        sideBar.addEventListener('mouseenter', function () {
            body.classList.remove('closed');
        });

        sideBar.addEventListener('mouseleave', function () {
            setTimeout(() => {
                if (!sideBar.matches(':hover')) {
                    body.classList.add('closed');
                }
            }, 500);
        });
    </script>
     
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../website/index.html");
    exit();
}

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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css">
    <link rel="shortcut icon" href="../assets/svg/ollcLogoNoName.svg" type="image/x-icon">
    <title>Admin Dashboard</title>
</head>
<body>
<header>
<div>
        <div class="flex py-4 px-14 justify-between items-center">
            <div>
                <img src="../assets/svg/ollclogo.svg" alt="">
            </div>
            <div class="inline-flex justify-between items-center gap-4">
                <div>
                    <button class="text-base"><a href="./website/index.html">Home</a></button>
                </div>
                <div class="relative group justify-center items-center">
                    <button id="admissionBtn" class="text-base focus:outline-none flex items-center gap-2 justify-center">Admission <img src="../assets/svg/arrow-down.svg" alt=""></button>
                    <ul id="admissionDropdown" class="absolute hidden bg-white text-gray-800 pt-2 group-hover:block">
                        <li><a href="./website/requirements.html" class="hover:text-blue-500">Requirements</a></li>
                        <li><a href="./website/pre-registration.html" class="hover:text-blue-500">Pre-Registration</a></li>
                    </ul>
                </div>
                <div class="relative group">
                    <button id="aboutBtn" class="text-base focus:outline-none flex items-center gap-2 justify-center">About OLLC <img src="../assets/svg/arrow-down.svg" alt=""></button>
                    <ul id="aboutDropdown" class="absolute hidden bg-white text-gray-800 pt-2 group-hover:block">
                        <li><a href="./mission-vision.html">Mission Vision</a></li>
                        <li><a href="./history.html">History</a></li>
                        <li><a href="./contact-us.html">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <button class="text-base btn"><a href="../login/student/login.php">Student Portal</a></button>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/topbar.js"></script>
</header>
    
    <!-- Admin dashboard-->
    <div id="side-bar">
        <div id="logo">
            <img id="logo" src="ollclogo.svg" alt="School Logo">
        </div>
 <!-- role-based sidebar -->
        <?php if (hasAccess(["admin"], $usertype)) : ?>
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

    
    <?php endif; ?>


    <?php if (hasAccess(["dean"], $usertype)) : ?>
        <a href="#"><i class="fas fa-user-graduate"></i><span class="text">Students</span></a>
        <a href="#"><i class="fas fa-book"></i><span class="text">Grades Report</span></a>
        <a href="#"><i class="fas fa-chalkboard-teacher"></i><span class="text">Faculty</span></a>
        <a href="#"><i class="fa-solid fa-calendar-days"></i><span class="text">School Calendar</span></a>
      
    <?php endif; ?>

    <?php if (hasAccess(["faculty"], $usertype)) : ?>
        <a href="#"><i class="fas fa-user-graduate"></i><span class="text">Students</span></a>
        <a href="#"><i class="fas fa-book"></i><span class="text">Grades Report</span></a>
        <a href="#"><i class="fas fa-chalkboard-teacher"></i><span class="text">Faculty</span></a>
        <a href="#"><i class="fa-solid fa-calendar-days"></i><span class="text">School Calendar</span></a>
      
    <?php endif; ?>

    <?php if (!hasAccess(["admin", "dean", "faculty"], $usertype)) : ?>
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

    <footer>
    <div>
        <object data="../website/footer.html" type="text/html" width="100%" height="56px"></object>
    </div>
    </footer>
</body>
</html>

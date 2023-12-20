<?php
function hasAccess($allowedUserTypes, $currentUserType) {
    return in_array($currentUserType, $allowedUserTypes);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>sidebar</title>
    <style>
    .sub-options {
        display: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var classesContainer = document.getElementById("classes-container");
        var subOptionsList = document.getElementById("subOptionsList");

        classesContainer.addEventListener("mouseenter", function () {
            subOptionsList.style.display = "block";
        });

        classesContainer.addEventListener("mouseleave", function () {
            subOptionsList.style.display = "none";
        });
    });
</script>
</head>

<body class="font-serif"> 
    <form action="../login/faculty/logout.php">
        <div id="sidebar" class="flex flex-col justify-between sidebar w-56 h-screen ease-linear duration-500 cursor-pointer sidebar-default" style="background-color: #4D81C8;">
            <div>
                <div class="px-2 py-4 flex items-center justify-start">
                    <div class="logo-container">
                        <img src="../assets/svg/ollcLogoNoName.svg" class="logo w-10 h-10" alt="">
                    </div>
                    <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="textDiv" style="letter-spacing: 2px;"> 
                        <span>
                            OUR LADY OF LOURDES
                        </span>
                        <span> 
                            COLLEGE
                        </span>
                    </div>
                </div>
                <div>
                    <div class="mt-14 ml-2">
                        <a href="dashboard.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/dashboard.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="dashboardText" style="letter-spacing: 2px;"> 
                                DASHBOARD
                            </div>
                        </a>
                    </div>

                    <?php if (hasAccess(['Admin', 'Developer'], $usertype)): ?>
                        <div class="ml-2">
                            <a href="account-management.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <img src="../assets/svg/account-management.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="accountManagementText" style="letter-spacing: 2px;"> 
                                    Account Management
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admission','Admin', 'Developer'], $usertype)): ?>
                        <div class="ml-2">
                            <a href="student-information.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <img src="../assets/svg/student.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="studentInformationText" style="letter-spacing: 2px;"> 
                                    Student Information
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admin', 'Developer'], $usertype)): ?>
                        <div class="ml-2">
                            <a href="faculty.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <img src="../assets/svg/professor.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="facultyText" style="letter-spacing: 2px;"> 
                                    Faculty
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admin', 'Developer', 'College Registrar'], $usertype)): ?>
                        <div class="ml-2">
                            <a href="enrollment-list.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <img src="../assets/svg/enrollment-list.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="enrollmentListText" style="letter-spacing: 2px;"> 
                                    Enrollment List
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="ml-2">
                            <a href="classes.php" class="px-2 flex items-center justify-start h-10 gap-3" id="classes">
                                <div class="logo-container">
                                    <img src="../assets/svg/account-management.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden"
                                    style="letter-spacing: 2px;">
                                    Class List
                                </div>
                            </a>

                            <!-- Sub-options for Class List -->
                            <ul id="subOptionsList" class="ml-4 sub-options">
                                <li>
                                    <a href="class-option1.php" class="text-white">Class Option 1</a>
                                </li>
                                <li>
                                    <a href="class-option2.php" class="text-white">Class Option 2</a>
                                </li>
                                <!-- Add more sub-options as needed -->
                            </ul>
                        </div>
                   <div class="ml-2">
                        <a href="grades.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/student.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="grades" style="letter-spacing: 2px;"> 
                                Students Grades
                            </div>
                        </a>
                    </div>
                 </div>
            
            <div class="ml-2">
                <button onclick="logout()" class="px-2 flex items-center justify-start h-10 gap-3">
                    <div class="logo-container px-2 flex items-center justify-start h-10 gap-3">
                        <img src="../assets/svg/logout.svg" class="logo w-6 h-6" alt="">
                    </div>
                    <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="logoutText" style="letter-spacing: 2px;">
                        Logout
                    </div>
                </button>
            </div>
        </div>
    </form>

</body>


</html>

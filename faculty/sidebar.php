<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>sidebar</title>
</head>

<body class="font-serif"> 
    <form action="../login/faculty/logout.php">
    <div id="sidebar" class="flex flex-col justify-between sidebar w-56 h-screen ease-linear duration-500 cursor-pointer" style="background-color: #4D81C8;">
            <div>
                <div class="px-2 py-4 flex items-center justify-start gap-3">
                    <div class="logo-container">
                        <img src="../assets/svg/ollcLogoNoName.svg" class="logo w-10 h-10" alt="">
                    </div>
                    <div class="tracking-wide justify-center items-center text-center text-white text-xs hidden" id="textDiv" style="letter-spacing: 2px;"> 
                        <span>OUR LADY OF LOURDES</span> <br>
                        <span style="letter-spacing: 7.20px;">COLLEGE</span> 
                    </div>
                </div>
                <div>
                    <div class="mt-14 ml-2">
                        <a href="dashboard.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/dashboard.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="dashboard" style="letter-spacing: 2px;"> 
                                DASHBOARD
                            </div>
                        </a>
                    </div>
                    <div class="ml-2">
                        <a href="classList.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/account-management.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="classes" style="letter-spacing: 2px;"> 
                                Class List
                            </div>
                        </a>
                    </div>
                    <div class="ml-2">
                        <a href="studentGrades.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/student.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="grades" style="letter-spacing: 2px;"> 
                                Students Grades
                            </div>
                        </a>
                    </div>
                    <div class="ml-2">
                        <a href="professorDetails.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/professor.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="requirements" style="letter-spacing: 2px;"> 
                              Profile Details
                            </div>
                        </a>
                    </div>
                    <div class="ml-2">
                        <a href="enrollment-list.php" class="px-2 flex items-center justify-start h-10 gap-3">
                            <div class="logo-container">
                                <img src="../assets/svg/enrollment-list.svg" class="logo w-6 h-6" alt="">
                            </div>
                            <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="enrollmentList" style="letter-spacing: 2px;"> 
                               
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="ml-2">
                <button onclick="logout()" class="px-2 flex items-center justify-start h-10 gap-3">
                    <div class="logo-container px-2 flex items-center justify-start h-10 gap-3">
                        <img src="../assets/svg/logout.svg" class="logo w-6 h-6" alt="">
                    </div>
                    <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="logout" style="letter-spacing: 2px;">
                        Logout
                    </div>
                </button>
            </div>
        </div>
    </form>
</body>

</html>

<?php
function hasAccess($allowedUserTypes, $currentUserType)
{
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
</head>

<body class="font-serif">
    <form action="../login/admin/logout.php">
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

                    <?php if (hasAccess(['Admin', 'Developer'], $usertype)) : ?>
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

                    <?php if (hasAccess(['Admission', 'Admin', 'Developer'], $usertype)) : ?>
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

                    <?php if (hasAccess(['Faculty', 'Admin', 'Developer'], $usertype)) : ?>
                        <div x-data="{ facultyDropdownOpen: false }" @mouseenter="facultyDropdownOpen = true" @mouseleave="facultyDropdownOpen = false" class="ml-2 relative">
                            <a href="#" class="px-2 flex items-center justify-start h-10 gap-3 cursor-pointer">
                                <div class="logo-container">
                                    <img src="../assets/svg/professor.svg" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="facultyText" style="letter-spacing: 2px;">
                                    Faculty
                                </div>
                            </a>

                            <!-- Dropdown menu for Faculty -->
                            <div x-show="facultyDropdownOpen" @click.away="facultyDropdownOpen = false" class="absolute top-0 left-full mt-0 ml-2 w-48 bg-white border rounded shadow-lg">
                                <div class="py-2">
                                    <a href="facultyAdvisory.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Advisory</a>
                                    <a href="facultyAdvisory.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Open Subjects</a>
                                    <!-- Add more links for Faculty dropdown as needed -->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admin', 'Developer', 'College Registrar'], $usertype)) : ?>
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

                    <?php if (hasAccess(['Admin', 'Developer', 'College Registrar'], $usertype)) : ?>
                        <div class="ml-2">
                            <a href="student-record.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <img src="../assets/svg/student-record-icon.png" class="logo w-6 h-6" alt="">
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="enrollmentListText" style="letter-spacing: 2px;">
                                    Student Record
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>
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

                            <div x-show="facultyDropdownOpen" @click.away="facultyDropdownOpen = false" class="z-50 absolute top-0 left-full mt-0 ml-2 w-48 bg-white border rounded shadow-lg">
                                <div class="py-2">
                                    <a href="facultyAdvisory.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Faculty List</a>
                                    <a href="assignfaculty.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Advisory</a>
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

                    <?php if (hasAccess(['Admin', 'Developer', 'College Registrar'], $usertype)) : ?>
                        <div class="ml-2">
                            <a href="school-calendar.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="enrollmentListText" style="letter-spacing: 2px;">
                                    School Calendar
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admin', 'Developer'], $usertype)) : ?>
                        <div class="ml-2">
                            <a href="manage-subject.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 4H8C6.89543 4 6 4.89543 6 6V19C6 20.1046 6.89543 21 8 21H17C18.1046 21 19 20.1046 19 19V6C19 4.89543 18.1046 4 17 4Z" stroke="white" stroke-width="2"/>
                                        <path d="M15 10V8M4 9H8M4 13H8M4 17H8" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="manageSubjectsText" style="letter-spacing: 2px;">
                                    Manage Subjects
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (hasAccess(['Admin', 'Developer'], $usertype)) : ?>
                        <div class="ml-2">
                            <a href="manageclass.php" class="px-2 flex items-center justify-start h-10 gap-3">
                                <div class="logo-container">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 4H8C6.89543 4 6 4.89543 6 6V19C6 20.1046 6.89543 21 8 21H17C18.1046 21 19 20.1046 19 19V6C19 4.89543 18.1046 4 17 4Z" stroke="white" stroke-width="2"/>
                                        <path d="M15 10V8M4 9H8M4 13H8M4 17H8" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="tracking-wide justify-start items-center text-center text-white text-xs hidden" id="manageSubjectsText" style="letter-spacing: 2px;">
                                    Manage Class
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
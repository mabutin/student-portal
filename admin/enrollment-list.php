<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$sort_condition = '';

if ($sort === 'name_asc') {
    $sort_condition = 'ORDER BY s.surname ASC, s.first_name ASC, s.middle_name ASC';
    $next_sort = 'name_desc';
} elseif ($sort === 'name_desc') {
    $sort_condition = 'ORDER BY s.surname DESC, s.first_name DESC, s.middle_name DESC';
    $next_sort = 'name_asc';
} else {
    $next_sort = 'name_asc';
}

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_condition = "AND (sn.student_number LIKE '%$search%' OR s.surname LIKE '%$search%' OR s.first_name LIKE '%$search%' OR s.middle_name LIKE '%$search%')";
} else {
    $search_condition = '';
}

$course_condition = '';
if (isset($_GET['course']) && $_GET['course'] !== '') {
    $selected_course = mysqli_real_escape_string($conn, $_GET['course']);
    $course_condition = "AND cr.course_name = '$selected_course'";
}

$year_condition = '';
if (isset($_GET['year']) && $_GET['year'] !== '') {
    $selected_year = mysqli_real_escape_string($conn, $_GET['year']);
    $year_condition = "AND yl.year_level = '$selected_year'";
}

$status_condition = '';
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $selected_status = mysqli_real_escape_string($conn, $_GET['status']);
    $status_condition = "AND si.status = '$selected_status'";
}

$queryNotification = "SELECT * FROM notifications ORDER BY datetime DESC";
$resultNotification = mysqli_query($conn, $queryNotification);

if (!$resultNotification) {
    die("Query failed: " . mysqli_error($conn));
}

$notifications = mysqli_fetch_all($resultNotification, MYSQLI_ASSOC);

mysqli_free_result($resultNotification);

$groupedNotifications = [];
foreach ($notifications as $notification) {
    $date = date('Y-m-d', strtotime($notification['datetime']));
    $groupedNotifications[$date][] = $notification;
}

$query = "SELECT sn.student_number, s.surname, s.first_name, s.middle_name, s.suffix, ed.course_id, yl.year_level, cr.course_name, si.status, s.suffix
            FROM student_information si
            JOIN students s ON si.student_id = s.student_id
            JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
            JOIN course cr ON ed.course_id = cr.course_id
            JOIN year_level yl ON ed.year_level_id = yl.year_level_id
            JOIN student_number sn ON s.student_number_id = sn.student_number_id
            WHERE 1 $search_condition $course_condition $year_condition $status_condition $sort_condition";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

$queryRequests = "SELECT * FROM request_messages ORDER BY request_datetime DESC";
$resultRequests = mysqli_query($conn, $queryRequests);

if (!$resultRequests) {
    die("Query failed: " . mysqli_error($conn));
}

$requestMessages = mysqli_fetch_all($resultRequests, MYSQLI_ASSOC);

mysqli_free_result($resultRequests);

$groupedRequests = [];
foreach ($requestMessages as $request) {
    $date = date('Y-m-d', strtotime($request['request_datetime']));
    $groupedRequests[$date][] = $request;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="../assets/js/student-information-menu.js"></script>
</head>

<body class="font-[roboto-serif]">
    <div class="flex justify-start overflow-y-hidden">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
            <div class="mt-4">
                <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold">
                    <div class="flex justify-start items-center gap-2">
                        <span>
                            Students
                        </span>
                        <span class="cursor-pointer">
                            <a href="../website/pre-registration.html">
                                <img src="../assets/svg/add.svg" class="logo w-5 h-5" alt="">
                            </a>
                        </span>
                    </div>
                    <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                    <div class="flex justify-start gap-4">
                        <div class="w-3/4">
                            <div class="flex justify-between items-center w-full gap-2">
                                <div class="w-2/4">
                                    <form action="" method="get" class="flex items-center gap-2">
                                        <label for="search" class="mr-2">Search:</label>
                                        <input type="text" id="search" name="search" class="w-full p-1 border border-blue-200 rounded-md" placeholder="Enter student number or name">
                                        <button type="submit" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Search</button>
                                    </form>
                                </div>
                                <div class="flex items-center justify-center gap-2">
                                    <form action="" method="get" id="filterForm" class="flex items-center gap-2">
                                        <select name="course" id="course" class="p-1 border border-blue-200 rounded-md">
                                            <option value="">All Courses</option>
                                            <?php
                                            $courses = [
                                                "Bachelor of Science in Information Technology" => "BSIT",
                                                "Bachelor of Science in Business Administration" => "BSBA",
                                                "Bachelor of Elementary Education" => "BEED",
                                                "Bachelor of Science in Criminology" => "BSCRIM",
                                                "Bachelor of Science in Hospitality Management" => "BSHM"
                                            ];

                                            foreach ($courses as $courseName => $courseCode) {
                                                $selected = (isset($_GET['course']) && $_GET['course'] == $courseName) ? 'selected' : '';
                                                echo "<option value=\"$courseName\" $selected>$courseCode</option>";
                                            }
                                            ?>
                                        </select>

                                        <select name="year" id="year" class="p-1 border border-blue-200 rounded-md">
                                            <option value="">All Years</option>
                                            <?php
                                            $yearLevels = ["First Year", "Second Year", "Third Year", "Fourth Year"];

                                            foreach ($yearLevels as $yearLevel) {
                                                $selected = (isset($_GET['year']) && $_GET['year'] == $yearLevel) ? 'selected' : '';
                                                echo "<option value=\"$yearLevel\" $selected>$yearLevel</option>";
                                            }
                                            ?>
                                        </select>

                                        <select name="status" id="status" class="p-1 border border-blue-200 rounded-md">
                                            <option value="">All Status</option>
                                            <?php
                                            $status = ["Pre-registered", "Registered", "Enrolled", "Not Enrolled"];

                                            foreach ($status as $statusLevel) {
                                                $selected = (isset($_GET['status']) && $_GET['status'] == $statusLevel) ? 'selected' : '';
                                                echo "<option value=\"$statusLevel\" $selected>$statusLevel</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <div>
                                        <button type="button" id="clearFiltersButton" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Clear Filters</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table-auto w-full mt-4">
                                <thead>
                                    <tr class="px-2 py-1 bg-blue-300">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Student Number</th>
                                        <th class="text-center"><a href="?sort=<?= $next_sort ?>">Name</a></th>
                                        <th class="text-center">Course</th>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBody">
                                    <?php foreach ($users as $index => $user) : ?>
                                        <tr class="px-2 py-1 <?= $index % 2 === 0 ? 'bg-white-500' : 'bg-blue-100' ?>">
                                            <td class="text-center"><?= $index + 1; ?></td>
                                            <td class="text-center">
                                                <?php if (isset($user['student_number'])) : ?>
                                                    <a href="#" data-student-id="<?= $user['student_number']; ?>" class="student-details-link">
                                                        <?= $user['student_number']; ?>
                                                    </a>
                                                <?php else : ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center"><?= isset($user['surname']) && isset($user['first_name']) && isset($user['middle_name']) ? $user['surname'] . ', ' . $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['suffix'] . '.' : 'N/A'; ?></td>
                                            <td class="text-center"><?= isset($user['course_name']) ? $user['course_name'] : 'N/A'; ?></td>
                                            <td class="text-center"><?= isset($user['year_level']) ? $user['year_level'] : 'N/A'; ?></td>
                                            <td class="text-center"><?= isset($user['status']) ? $user['status'] : 'N/A'; ?></td>
                                            <td class="text-center">
                                                <?php if ($user['status'] === 'Enrolled') : ?>
                                                    <button type="button" onclick="enrollStudent(<?= $user['student_number']; ?>, <?= $index; ?>)" title="Mark as Officially Enrolled">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.1 12.5L22.5 13.91L15.97 20.5L12.5 17L13.9 15.59L15.97 17.67L21.1 12.5ZM10 17L13 20H3V18C3 15.79 6.58 14 11 14L12.89 14.11L10 17ZM11 4C12.0609 4 13.0783 4.42143 13.8284 5.17157C14.5786 5.92172 15 6.93913 15 8C15 9.06087 14.5786 10.0783 13.8284 10.8284C13.0783 11.5786 12.0609 12 11 12C9.93913 12 8.92172 11.5786 8.17157 10.8284C7.42143 10.0783 7 9.06087 7 8C7 6.93913 7.42143 5.92172 8.17157 5.17157C8.92172 4.42143 9.93913 4 11 4Z" fill="#2F88FF"/>
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                                <input type="hidden" name="studentId" value="<?= $user['student_number']; ?>">
                                                <input type="hidden" name="newStatus" value="Enrolled">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="border-l-2 border-blue-300">
                            <div id="tabsContainer" class="pl-2 h-full">
                                <div id="studentDetailsContainer" class="overflow-y-auto mt-2 shadow-md" style="width: 816px; height: 700px; display: none;">
                                    <script>
                                        function printStudentDetails() {
                                            var printContents = document.getElementById('printable_div_id').innerHTML;
                                            var originalContents = document.body.innerHTML;
                                            document.body.innerHTML = '<div id="printable_div_id">' + printContents + '</div>';
                                            window.print();
                                            document.body.innerHTML = originalContents;
                                        }
                                    </script>
                                </div>
                                <div class="h-1/2">
                                    <div class="flex">
                                        <div id="notificationTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr hidden" onclick="showTab('notificationTabContent', 'notificationTab', 'requestsTab')">
                                            Notification
                                        </div>
                                        <div id="requestsTab" class="tab px-2 cursor-pointer rounded-tl rounded-tr" onclick="showTab('requestsTabContent', 'requestsTab', 'notificationTab')">
                                            Requests
                                        </div>
                                    </div>
                                    <div id="notificationTabContent" class="tab-content p-4">   
                                    </div>
                                    <div id="requestsTabContent" class="tab-content px-4">
                                        <?php if (!empty($requestMessages)) : ?>
                                            <?php foreach ($requestMessages as $requestMessage) : ?>
                                                <div class="border-t border-b border-gray-200 w-full p-2 rounded">
                                                    <div class="font-semibold">
                                                        <?php if (isset($requestMessage['student_number'])) : ?>
                                                            <a href="#" data-student-id="<?= $requestMessage['student_number']; ?>" class="student-details-link request-student-link">
                                                                <?= $requestMessage['student_number']; ?>
                                                            </a>
                                                        <?php else : ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="font-semibold"><?= $requestMessage['message']; ?></div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php if (isset($requestMessage['request_datetime'])) : ?>
                                                            <?= formatDateHeading($requestMessage['request_datetime']); ?>
                                                        <?php else : ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <div>No new requests</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
    <script src="../assets/js//enrollment-tab.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    function enrollStudent(studentNumber, rowIndex) {
        // Assuming you have a PHP script to handle the database update
        var url = 'update_status.php';

        // Make an AJAX request
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                studentNumber: studentNumber,
                newStatus: 'Officially Enrolled'
            },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Check if the update was successful
                if (data.success) {
                    // Update the status in the table without page reload
                    $('#statusCell_' + rowIndex).text('Officially Enrolled');

                    // Refresh the page after a short delay (e.g., 1000 milliseconds or 1 second)
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Handle the error if needed
                    console.error('Error updating status: ', data.error);
                }
            },
            error: function(error) {
                console.error('Error updating status: ', error);
            }
        });
    }
</script>

    <?php
    function formatDate($datetime)
    {
        $formattedDate = date('F j, Y, g:i a', strtotime($datetime));
        return $formattedDate;
    }
    ?>

</html>
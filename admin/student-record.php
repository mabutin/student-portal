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


$query = "SELECT sn.student_number, s.surname, s.first_name, s.middle_name, s.suffix, ed.course_id, cr.course_name, yl.year_level, si.status, s.suffix
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



// First query for 'request_tor' table
$queryRequestsTOR = "SELECT * FROM request_tor ORDER BY request_datetime DESC";
$resultRequestsTOR = mysqli_query($conn, $queryRequestsTOR);

if (!$resultRequestsTOR) {
    die("Query failed for request_tor: " . mysqli_error($conn));
}

$requestMessagesTOR = mysqli_fetch_all($resultRequestsTOR, MYSQLI_ASSOC);

mysqli_free_result($resultRequestsTOR);

// Second query for 'request_goodmoral' table
$queryRequestsGoodMoral = "SELECT * FROM request_goodmoral ORDER BY request_datetime DESC";
$resultRequestsGoodMoral = mysqli_query($conn, $queryRequestsGoodMoral);

if (!$resultRequestsGoodMoral) {
    die("Query failed for request_goodmoral: " . mysqli_error($conn));
}

$requestMessagesGoodMoral = mysqli_fetch_all($resultRequestsGoodMoral, MYSQLI_ASSOC);

mysqli_free_result($resultRequestsGoodMoral);

// Third query for 'request_honorable' table
$queryRequestsHonorable = "SELECT * FROM request_honorable ORDER BY request_datetime DESC";
$resultRequestsHonorable = mysqli_query($conn, $queryRequestsHonorable);

if (!$resultRequestsHonorable) {
    die("Query failed for request_honorable: " . mysqli_error($conn));
}

$requestMessagesHonorable = mysqli_fetch_all($resultRequestsHonorable, MYSQLI_ASSOC);

mysqli_free_result($resultRequestsHonorable);

// Combine all results into a single array
$requestMessages = array_merge($requestMessagesTOR, $requestMessagesGoodMoral, $requestMessagesHonorable);

// Group the combined results by date
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
    <title>Student Record</title>
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
                        <!-- <span class="cursor-pointer">
                            <a href="../website/pre-registration.html">
                                <img src="../assets/svg/add.svg" class="logo w-5 h-5" alt="">
                            </a>
                        </span> -->
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
                                            <td class="text-center"><?= isset($user['course']) ? $user['course'] : 'N/A'; ?></td>
                                            <td class="text-center"><?= isset($user['year_level']) ? $user['year_level'] : 'N/A'; ?></td>
                                            <td class="text-center"><?= isset($user['status']) ? $user['status'] : 'N/A'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="border-l-2 border-blue-300">
                            <div id="tabsContainer" class="pl-2 h-full">
                                <div id="studentDetailsContainer" class="overflow-y-auto mt-2 shadow-md" style="width: 816px; height: 630px; display: none;">
                                    <!-- <script>
                                        function printStudentDetails() {
                                            var printContents = document.getElementById('printable_div_id').innerHTML;
                                            var originalContents = document.body.innerHTML;
                                            document.body.innerHTML = '<div id="printable_div_id">' + printContents + '</div>';
                                            window.print();
                                            document.body.innerHTML = originalContents;
                                        }
                                    </script> -->
                                </div>

                                <div class="h-1/2">
                                    <div class="flex">
                                        <div id="notificationTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr hidden" onclick="showTab('notificationTabContent', 'notificationTab', 'requestsTab')">
                                            Notification
                                        </div>
                                        <div id="requestsTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr " onclick="showTab('requestsTabContent', 'requestsTab', 'notificationTab')">
                                            Requests
                                        </div>
                                    </div>
                                    <div id="notificationTabContent" class="tab-content p-4 hidden">
                                    </div>
                                    <div id="requestsTabContent" class="tab-content p-4">
                                        <?php if (!empty($requestMessages)) : ?>
                                            <?php foreach ($requestMessages as $requestMessage) : ?>
                                                <div class="border-t border-b border-gray-200 p-2 rounded " style="width:300px;">
                                                    <div class="text-sm font-medium">
                                                        <?php if (isset($requestMessage['student_number'])) : ?>
                                                            <a href="#" data-student-id="<?= $requestMessage['student_number']; ?>" class="student-details-link request-student-link">
                                                                <p>Student Name: <span class="ml-1 font-normal"><?= isset($user['surname']) && isset($user['first_name']) && isset($user['middle_name']) ? $user['surname'] . ', ' . $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['suffix'] : 'N/A'; ?></span></p>
                                                                <p>Student Number: <span class="ml-1 font-normal"><?= $requestMessage['student_number']; ?></span></p>
                                                                <p>Requested Document:<span class="ml-1 font-normal"><?= $requestMessage['document_type']; ?></span></p>
                                                            </a>
                                                        <?php else : ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-sm font-medium mb-1.5">
                                                        <p>Purpose: <span class="ml-1 font-normal"><?= $requestMessage['message']; ?></span></p>
                                                    </div>
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
    <script src="../assets/js/student-record-documents-tab.js"></script>

</html>
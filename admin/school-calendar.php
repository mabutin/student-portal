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
    <title>Student Information</title>
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
            
                            

                    
                
            
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
    <script src="../assets/js/student-information-tab.js"></script>
    <?php
    function formatDate($datetime)
    {
        $formattedDate = date('F j, Y, g:i a', strtotime($datetime));
        return $formattedDate;
    }
    ?>

</html>
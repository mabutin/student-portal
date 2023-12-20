<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';
    
date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, ed.course
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        WHERE sn.student_number = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}

$stmt->bind_param("s", $studentNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Error in query execution: " . $stmt->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $course = $row['course'];
    $suffix = $row['suffix'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Student Grades</title>
    
</head>

<body class="font-serif"> 
    <form action="../login/student/logout.php">
        <div class="flex">
    <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
    </form>

    
    <script src="../assets/js/studentSidebar.js"></script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.student_id = st.student_id
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
    $suffix = $row['suffix'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

// Fetch distinct years from the subject table
$sql_years = "SELECT DISTINCT year FROM subject";
$result_years = $conn->query($sql_years);

if ($result_years) {
    $years = [];
    while ($row_years = $result_years->fetch_assoc()) {
        $years[] = $row_years['year'];
    }
}

// Fetch distinct courses from the subject table
$sql_courses = "SELECT DISTINCT course FROM subject";
$result_courses = $conn->query($sql_courses);

if ($result_courses) {
    $courses = [];
    while ($row_courses = $result_courses->fetch_assoc()) {
        $courses[] = $row_courses['course'];
    }
}

$sql_courses = "SELECT DISTINCT course FROM subject";
$result_courses = $conn->query($sql_courses);

if ($result_courses) {
    $courses = [];
    while ($row_courses = $result_courses->fetch_assoc()) {
        $courses[] = $row_courses['course'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Admission Page</title>
</head>
<body>
    <div style="background: radial-gradient(at center, rgba(118, 163, 224, 0.5  ), #FFFFFF);">
        <div>
            <?php include './topbar.php'; ?>
        </div>
        
    </div>
    <script src="../assets/js/enrollment-menu.js"></script>
</body>
</html>

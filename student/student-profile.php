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
    <title>Student Profile</title>
</head>
<body>
    <div class="w-full flex">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full">
            <div>
                <?php include './topbarStudent.php'; ?>
            </div>
            <div class="px-14 py-2">
                <div class="border border-blue-100 shadow-md p-4 bg-white">
                    <div class="font-semibold">
                        Student Profile
                    </div>
                    <div class="mt-4">
            <strong>Last Name:</strong> <?php echo htmlspecialchars($surname, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="mt-2">
            <strong>First Name:</strong> <?php echo htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="mt-2">
            <strong>Middle Name:</strong> <?php echo htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="mt-2">
            <strong>Contact Information:</strong> <!-- Add your contact information variable here -->
        </div>
        <div class="mt-2">
            <strong>Course:</strong> <?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="mt-2">
            <strong>Status:</strong> <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
        </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/studentSidebar.js"></script>
</body>
</html>
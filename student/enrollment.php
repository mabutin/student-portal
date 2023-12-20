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
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Admission Page</title>
</head>
<body>
    <div style="background: radial-gradient(at center, rgba(118, 163, 224, 0.5  ), #FFFFFF);">
        <div>
            <?php include './topbar.php'; ?>
        </div>
        <div class="w-full"><img src="../assets/img/admission-banner.png" class="w-full" alt=""></div>
        <div class="w-full flex justify-center mt-4 mb-14">
            <div class="w-1/2 p-4 border border-blue-800 border-opacity-20">
                <form action="" class="grid gap-2">
                    <h1 class="text-xl font-bold text-gray-900 text-center pt-4">Enrollment Process</h1>
                    <div>
                        <span class="font-semibold">You're applying for:</span>
                        <span><?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div>
                        <span class="font-semibold">Name: </span>
                        <span><?php echo htmlspecialchars($firstName . ' ' . $middleName . ' ' . $surname, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div>
                        <span class="font-semibold">Student Type:</span>
                        <span>
                            <select name="" id="studentTypeMenu" class="text-sm p-1 border border-blue-200 rounded-md" onchange="updateForm()">
                            </select>
                        </span>
                    </div>
                    <div id="enrollmentProcessText"></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/enrollment-menu.js"></script>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

// Fetch student information
$sqlStudentInfo = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture, ed.course_id, cr.course_name, yl.year_level
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN course cr ON ed.course_id = cr.course_id
        JOIN year_level yl ON ed.year_level_id = yl.year_level_id
        JOIN students st ON si.student_id = st.student_id
        WHERE sn.student_number = ?";

$stmtStudentInfo = $conn->prepare($sqlStudentInfo);

if (!$stmtStudentInfo) {
    die("Error in SQL query: " . $conn->error);
}

$stmtStudentInfo->bind_param("s", $studentNumber);
$stmtStudentInfo->execute();
$resultStudentInfo = $stmtStudentInfo->get_result();

if ($resultStudentInfo === false) {
    die("Error in query execution: " . $stmtStudentInfo->error);
}

if ($resultStudentInfo->num_rows == 1) {
    $row = $resultStudentInfo->fetch_assoc();

    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $course = $row['course_name'];
    $suffix = $row['suffix'];

    $stmtStudentInfo->close();
} else {
    header("Location: ../../login.php");
    exit();
}

// Enrollment process (you need to adapt this based on your actual implementation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll_subjects'])) {
    $enrolledSubjects = $_POST['enroll_subjects']; // Assuming this comes from a form

    // Debugging output
    echo "Enrolled Subjects Array: ";
    var_dump($enrolledSubjects);

    // Clear existing enrolled subjects for the student
    $sqlDeleteEnrolledSubjects = "DELETE FROM enrolled_subjects WHERE student_id = ?";
    $stmtDeleteEnrolledSubjects = $conn->prepare($sqlDeleteEnrolledSubjects);

    if (!$stmtDeleteEnrolledSubjects) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmtDeleteEnrolledSubjects->bind_param("s", $studentNumber);
    $stmtDeleteEnrolledSubjects->execute();

    $stmtDeleteEnrolledSubjects->close();

    // Insert newly selected subjects
    $sqlInsertEnrolledSubjects = "INSERT INTO enrolled_subjects (student_id, subject_id) VALUES (?, ?)";
    $stmtInsertEnrolledSubjects = $conn->prepare($sqlInsertEnrolledSubjects);

    if (!$stmtInsertEnrolledSubjects) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmtInsertEnrolledSubjects->bind_param("ss", $studentNumber, $subjectId);

    foreach ($enrolledSubjects as $subjectId) {
        $stmtInsertEnrolledSubjects->execute();
    }

    $stmtInsertEnrolledSubjects->close();

    // Redirect to the dashboard or refresh the page after enrollment
    header("Location: dashboard.php");
    exit();
}

// Fetch enrolled subjects
$sqlEnrolledSubjects = "SELECT es.subject_id, s.code, s.name, s.unit
                       FROM enrolled_subjects es
                       JOIN subjects s ON es.subject_id = s.subject_id
                       WHERE es.student_id = ?";

$stmtEnrolledSubjects = $conn->prepare($sqlEnrolledSubjects);

if (!$stmtEnrolledSubjects) {
    die("Error in SQL query: " . $conn->error);
}

$stmtEnrolledSubjects->bind_param("s", $studentNumber);
$stmtEnrolledSubjects->execute();
$resultEnrolledSubjects = $stmtEnrolledSubjects->get_result();

if ($resultEnrolledSubjects === false) {
    die("Error in query execution: " . $stmtEnrolledSubjects->error);
}

$enrolledSubjects = $resultEnrolledSubjects->fetch_all(MYSQLI_ASSOC);

$stmtEnrolledSubjects->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Student Dashboard</title>
    <style>
        section {
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #648EC7;
            color: white;
        }
    </style>
</head>

<body class="font-serif">
    <form action="../login/student/logout.php">
        <!-- Your existing HTML content... -->
        <div class="flex">
            <div>
                <?php include './sidebar.php'; ?>
            </div>
            <div class="w-full py-4 px-4">
                <div>
                    <?php include './topbarStudent.php'; ?>
                </div>
                <div>
                    <section>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($firstName . ' ' . $middleName . '. ' . $surname, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($studentNumber, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Program:</strong> <?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?></p>
                    </section>
                    <!-- Display enrolled subjects -->
                    <section>
                        <h2>Subjects</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Units</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($enrolledSubjects as $subject): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subject['code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($subject['unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                    <script src="../assets/js/studentSidebar.js"></script>
                    <!-- Your existing JavaScript and other scripts... -->
                </div>
            </div>
        </div>
    </form>
</body>

</html>
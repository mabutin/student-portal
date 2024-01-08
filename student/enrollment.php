<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = isset($_SESSION['student_number']) ? $_SESSION['student_number'] : null;

$sql = "SELECT st.student_id, st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture, ed.course_id, cr.course_name, yl.year_level
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN course cr ON ed.course_id = cr.course_id
        JOIN year_level yl ON ed.year_level_id = yl.year_level_id
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

    $studentId = $row['student_id'];
    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $suffix = $row['suffix'];
    $admissionType = isset($_POST['admissionType']) ? $_POST['admissionType'] : '';

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

function getCurrentSchoolYearAndSemester() {
    $currentMonth = date('n');

    $startMonth = ($currentMonth >= 7) ? 7 : 1;

    $startYear = ($currentMonth >= 7) ? date('Y') : date('Y') - 1;
    $endYear = $startYear + 1;

    $semester = ($currentMonth >= 7 && $currentMonth <= 12) ? 'First Semester' : 'Second Semester';

    $schoolYear = $startYear . '-' . $endYear;

    return array('schoolYear' => $schoolYear, 'semester' => $semester);
}

$schoolInfo = getCurrentSchoolYearAndSemester();
$schoolYear = $schoolInfo['schoolYear'];
$semester = $schoolInfo['semester'];

$selectedCourse = $row['course_id'];

$courses = [
    1 => "Bachelor of Science in Information Technology",
    2 => "Bachelor of Science in Hospitality Management",
    3 => "Bachelor of Science in Business Administration",
    4 => "Bachelor of Elementary Education",
    5 => "Bachelor of Secondary Education major in English",
    6 => "Bachelor of Secondary Education major in Mathematics",
    7 => "Bachelor of Science in Criminology"
];

$selectedYearLevel = isset($row['year_level_id']) ? $row['year_level_id'] : 0;

$yearLevels = [
    1 => "First Year",
    2 => "Second Year",
    3 => "Third Year",
    4 => "Fourth Year"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveSubjects'])) {
    $selectedCourse = $_POST['course'];
    $selectedYearLevel = $_POST['yearLevel'];
    $admissionType = $_POST['admissionType'];

    $currentMonth = date('n');
    $selectedSemester = ($currentMonth >= 7 && $currentMonth <= 12) ? 2 : 1;

    $updateSql = "UPDATE enrollment_details AS ed
        JOIN student_information AS si ON ed.enrollment_details_id = si.enrollment_details_id
        JOIN students AS st ON si.student_id = st.student_id
        JOIN student_number AS sn ON st.student_number_id = sn.student_number_id
        SET ed.course_id = ?, ed.year_level_id = ?, ed.semester_tbl_id = ?, ed.admission_type = ?, ed.school_year = ?, si.status = 'Enrolled'
        WHERE sn.student_number = ?";

    $updateStmt = $conn->prepare($updateSql);

    if (!$updateStmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $updateStmt->bind_param("iiissi", $selectedCourse, $selectedYearLevel, $selectedSemester, $admissionType, $schoolYear, $studentNumber);
    $updateStmt->execute();

    if ($updateStmt->error) {
        die("Error updating enrollment details: " . $updateStmt->error);
    }

    $updateStmt->close();

    $enrolledSubjects = isset($_POST['enrolled_subjects']) ? $_POST['enrolled_subjects'] : [];

    $insertSubjectsSql = "INSERT INTO enrolled_subjects (student_id, year_level_id, semester_tbl_id, subject_id, school_year)
                          VALUES (?, ?, ?, ?, ?)";
    $insertSubjectsStmt = $conn->prepare($insertSubjectsSql);

    if (!$insertSubjectsStmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $yearLevelId = $selectedYearLevel;
    $semesterId = $selectedSemester; 

    foreach ($enrolledSubjects as $subjectId) {
        $insertSubjectsStmt->bind_param("iiiss", $studentId, $yearLevelId, $semesterId, $subjectId, $schoolYear);
        $insertSubjectsStmt->execute();

        if ($insertSubjectsStmt->error) {
            die("Error inserting enrolled subject: " . $insertSubjectsStmt->error);
        }
    }

    $insertSubjectsStmt->close();

    $notificationMessage = "$firstName $surname completed the enrollment process.";
    $notificationDatetime = date('Y-m-d H:i:s');
    $sqlUpdateNotification = "UPDATE notifications SET message = ?, datetime = ? WHERE message LIKE ?";
    $updateNotificationStmt = $conn->prepare($sqlUpdateNotification);
    $updateNotificationMessage = "%$firstName $surname%";
    $updateNotificationStmt->bind_param("sss", $notificationMessage, $notificationDatetime, $updateNotificationMessage);
    $updateNotificationStmt->execute();

    if ($updateNotificationStmt->error) {
        die("Error updating notification: " . $updateNotificationStmt->error);
    }

    $updateNotificationStmt->close();

    header("Location: paymentReference.php");

    exit();
}

if ($studentNumber) {
    $sql = "SELECT s.student_id
            FROM students s
            JOIN student_number sn ON s.student_number_id = sn.student_number_id
            WHERE sn.student_number = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $studentNumber);
    $stmt->execute();

    $stmt->bind_result($studentId);

    if (!$stmt->fetch()) {
        die("Error fetching student_id: " . $stmt->error);
    }

    $stmt->close();

} else {
    echo "Student Number not available in session.";
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
            <div>
                <form action="" method="post">
                    <div class="w-full flex justify-center items-center">
                        <div class="w-1/2 p-4 border border-blue-800 border-opacity-20 p-2 my-4 rounded-md drop-shadow-md bg-white">
                            <div class="font-bold text-2xl mb-4">
                                Enrollment
                            </div>
                            <div class="text-base">
                                <div class="italic mb-6">
                                    Welcome to Our Lady of Lourdes College enrollment process! We're thrilled to guide you through the steps of completing your enrollment form and confirming your subjects. Once you've completed this process, you'll be ready to proceed to payment and officially enroll with us.
                                    <br><br>
                                    To get started, please provide the required information, confirm your subjects, and follow the instructions provided. If you have any questions or need assistance, feel free to reach out to our enrollment support team. We're here to help you every step of the way.
                                    <br><br>
                                    Thank you for choosing Our Lady of Lourdes College. We look forward to welcoming you to our community!
                                </div>
                                <div class="grid gap-2">
                                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="text-md font-semibold">You're Applying: </div>
                                    <div class="flex  items-center gap-2">
                                        <span class="text-sm font-semibold">Course:</span>
                                        <select name="course" class="text-sm p-1 border border-blue-200 rounded-md">
                                            <?php foreach ($courses as $courseId => $courseName) : ?>
                                                <option value="<?= $courseId ?>" <?= ($selectedCourse == $courseId) ? 'selected' : '' ?>>
                                                    <?= $courseName ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex  items-center gap-2">
                                        <span class="text-sm font-semibold">Year Level:</span>
                                        <select name="yearLevel" class="text-sm p-1 border border-blue-200 rounded-md">
                                            <?php foreach ($yearLevels as $yearLevelId => $yearLevelName) : ?>
                                                <option value="<?= $yearLevelId ?>" <?= ($selectedYearLevel == $yearLevelId) ? 'selected' : '' ?>>
                                                    <?= $yearLevelName ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex  items-center gap-2">
                                        <span class="text-sm font-semibold">School Year:</span>
                                        <span><?= $schoolYear ?></span>
                                    </div>
                                    <div class="flex  items-center gap-2">
                                        <span class="text-sm font-semibold">Semester:</span>
                                        <span><?= $semester ?></span>
                                    </div>
                                    <div class="flex  items-center gap-2">
                                        <div class="text-sm font-semibold">Admission Type:</div>
                                        <select name="admissionType" class="text-sm p-1 border border-blue-200 rounded-md">
                                            <option value="New Student">New Student</option>
                                            <option value="Transferee">Transferee</option>
                                        </select>
                                    </div>
                                    <div>
                                        <table class="table-auto w-full">
                                            <thead>
                                                <tr class="justify-between bg-blue-200">
                                                    <td style="width: 20%;" class="text-center">Code</td>
                                                    <td style="width: 50%;" class="text-center">Subject</td>
                                                    <td style="width: 30%;" class="text-center">Units</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include '../php/conn.php';

                                                    $yearLevelMapping = [
                                                        'First Year' => 1,
                                                        'Second Year' => 2,
                                                        'Third Year' => 3,
                                                        'Fourth Year' => 4,
                                                    ];

                                                    $semesterMapping = [
                                                        'First Semester' => 1,
                                                        'Second Semester' => 2,
                                                    ];

                                                    $selectedYearLevel = array_search($row['year_level'], $yearLevels);
                                                    $selectedSemester = $semesterMapping[$semester];

                                                    $sql = "SELECT os.open_subject_id, s.subject_id, s.code, s.name, s.unit
                                                            FROM open_subjects os
                                                            JOIN subjects s ON os.subject_id = s.subject_id
                                                            WHERE os.course_id = ? AND os.year_level_id = ? AND os.semester_tbl_id = ?";

                                                    $stmt = $conn->prepare($sql);

                                                    if (!$stmt) {
                                                        die("Error in SQL query: " . $conn->error);
                                                    }

                                                    $stmt->bind_param("iii", $selectedCourse, $selectedYearLevel, $selectedSemester);
                                                    $stmt->execute();

                                                    if ($stmt->error) {
                                                        die("Error in query execution: " . $stmt->error);
                                                    }

                                                    $result = $stmt->get_result();

                                                    $row_number = 0;  

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                    
                                                            $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';
                                                            echo "<tr class='$row_class'>
                                                                <td class='pl-16 hidden'><input type=\"text\" name=\"enrolled_subjects[]\" value=\"{$row['subject_id']}\"></td>
                                                                <td class='pl-16'>{$row['code']}</td>
                                                                <td class='text-center'>{$row['name']}</td>
                                                                <td class='text-center'>{$row['unit']}</td>
                                                            </tr>";
                                                            $row_number++;
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                    }                                                    

                                                    $stmt->close();
                                                    mysqli_close($conn);
                                                    ?>
                                            </tbody>
                                        </table>
                                        <div class="flex items-center justify-center gap-4">
                                            <button class="p-2 bg-blue-400 rounded-md text-xs text-white hover:text-white hover:bg-blue-700 my-4" type="submit" name="saveSubjects">Proceed to Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="../assets/js/enrollment-menu.js"></script>
    </script>
    </body>
    </html>

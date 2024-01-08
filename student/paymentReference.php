<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

if (!isset($_SESSION['reference_number'])) {
    $_SESSION['reference_number'] = generateReferenceNumber();

    $enrollmentDetailsId = getEnrollmentDetailsId($conn, $studentNumber);

    if ($enrollmentDetailsId) {
        updateReferenceNumber($conn, $enrollmentDetailsId, $_SESSION['reference_number']);
    }
}

function generateReferenceNumber() {
    $referenceNumber = '';

    for ($i = 0; $i < 23; $i++) {
        $referenceNumber .= mt_rand(0, 9); 
    }

    return $referenceNumber;
}

function getEnrollmentDetailsId($conn, $studentNumber) {
    $sql = "SELECT ed.enrollment_details_id
            FROM student_number sn
            JOIN school_account sa ON sn.student_number_id = sa.student_number_id
            JOIN student_information si ON sa.school_account_id = si.school_account_id
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

    $row = $result->fetch_assoc();

    $enrollmentDetailsId = $row['enrollment_details_id'];

    $stmt->close();

    return $enrollmentDetailsId;
}
$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture, ed.course_id, cr.course_name, yl.year_level
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

    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $course = $row['course_name'];
    $suffix = $row['suffix'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

function updateReferenceNumber($conn, $enrollmentDetailsId, $referenceNumber) {
    $updateSql = "UPDATE enrollment_details SET reference_no = ? WHERE enrollment_details_id = ?";
    $updateStmt = $conn->prepare($updateSql);

    if (!$updateStmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $updateStmt->bind_param("si", $referenceNumber, $enrollmentDetailsId);
    $updateStmt->execute();

    if ($updateStmt->affected_rows < 1) {
        die("Error updating reference number: " . $updateStmt->error);
    }

    $updateStmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Payment Reference Number</title>
    <style>
        @media print {
            body {
                width: 80%; /* Adjust the width as needed for printing */
                margin: auto; /* Center the content when printing */
            }

            /* Add any additional print-specific styles here */
        }
    </style>
</head>

<body class="font-serif"> 
    <div>   
        <?php include './topbar.php'; ?>
    </div>
    <div style="background: radial-gradient(at center, rgba(118, 163, 224, 0.5  ), #FFFFFF);">
        <div class="w-full inline-flex justify-center bg-white">
            <div class="w-1/2 p-4 border border-blue-800 border-opacity-20 p-2 my-4 rounded-md drop-shadow-md bg-white" id='printable_div_id'>
                <div class="flex justify-center mb-5">
                    <img src="../assets/svg/ollclogo.svg" class="h-20" alt="">
                </div>
                <p><strong>Good Day!</strong> <?php echo $firstName; ?>!</p> <br>
                <p><i>Congratulations on completing the enrollment process at OLLC Campus! To finalize your enrollment, please follow the instructions below:</i></p> <br>
                <il>
                    <li>Visit the OLLC Campus office to print your copy of the registration card.</li>
                    <li>Proceed to the cashier's office to make the payment for your tuition fee.</li>
                    <li>Your tuition fee payment confirms your official enrollment at OLLC.</li>
                </il><br>
                <p><i>Please ensure to save and take note of your Enrollment Reference Number for future reference.</i></p> <br>
                <p><strong>Enrollment Reference Number:</strong> <?php echo $_SESSION['reference_number']; ?></p> <br>
                <p>Present your Enrollment Reference Number at the campus office for any further assistance or clarification.</p> <br>
                <p>We look forward to welcoming you officially to OLLC Campus and wish you a successful academic journey!</p><br>
                <p><strong>Best regards,</strong><br>
                    Our Lady of Lourdes College
            </div>
        </div>
        <div class="grid w-full justify-center">
            <button onClick="printStudentDetails();" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">
                Print
            </button>
        </div>
    <script src="../assets/js/studentSidebar.js"></script>
    <script>
        function printStudentDetails() {
            var printContent = document.getElementById('printable_div_id').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;

            window.print();

            document.body.innerHTML = originalContent;
        }
    </script>
</body>

</html>

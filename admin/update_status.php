<?php
// Assuming you have a database connection established
include '../php/conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentNumber = $_POST['studentNumber'];
    $newStatus = $_POST['newStatus'];

    // Update student_information
    $updateStudentInformationSql = "UPDATE student_information AS si
            JOIN students AS s ON si.student_id = s.student_id
            JOIN student_number AS sn ON s.student_number_id = sn.student_number_id
            SET si.status = ?
            WHERE sn.student_number = ?";

    $stmtStudentInformation = $conn->prepare($updateStudentInformationSql);

    if (!$stmtStudentInformation) {
        echo json_encode(['success' => false, 'error' => 'Statement preparation error for student information: ' . $conn->error]);
        exit;
    }

    $stmtStudentInformation->bind_param('ss', $newStatus, $studentNumber);

    if (!$stmtStudentInformation->execute()) {
        echo json_encode(['success' => false, 'error' => 'Error updating student information: ' . $stmtStudentInformation->error]);
        exit;
    }

    // Close the statement
    $stmtStudentInformation->close();

    // Get enrollment_details_id from student_information
    $getEnrollmentDetailsIdSql = "SELECT enrollment_details_id FROM student_information WHERE student_id = (SELECT student_id FROM students WHERE student_number_id = (SELECT student_number_id FROM student_number WHERE student_number = ?))";

    $stmtGetEnrollmentDetailsId = $conn->prepare($getEnrollmentDetailsIdSql);

    if (!$stmtGetEnrollmentDetailsId) {
        echo json_encode(['success' => false, 'error' => 'Statement preparation error for getting enrollment_details_id: ' . $conn->error]);
        exit;
    }

    $stmtGetEnrollmentDetailsId->bind_param('s', $studentNumber);

    if (!$stmtGetEnrollmentDetailsId->execute()) {
        echo json_encode(['success' => false, 'error' => 'Error getting enrollment_details_id: ' . $stmtGetEnrollmentDetailsId->error]);
        exit;
    }

    $stmtGetEnrollmentDetailsId->bind_result($enrollmentDetailsId);
    $stmtGetEnrollmentDetailsId->fetch();

    // Close the statement
    $stmtGetEnrollmentDetailsId->close();

    // Update enrollment_details with the current date
    $updateEnrollmentDetailsSql = "UPDATE enrollment_details SET enrollment_date = CURRENT_DATE() WHERE enrollment_details_id = ?";

    $stmtEnrollmentDetails = $conn->prepare($updateEnrollmentDetailsSql);

    if (!$stmtEnrollmentDetails) {
        echo json_encode(['success' => false, 'error' => 'Statement preparation error for updating enrollment details: ' . $conn->error]);
        exit;
    }

    $stmtEnrollmentDetails->bind_param('i', $enrollmentDetailsId);

    if (!$stmtEnrollmentDetails->execute()) {
        echo json_encode(['success' => false, 'error' => 'Error updating enrollment details: ' . $stmtEnrollmentDetails->error]);
        exit;
    }

    // Close the statement
    $stmtEnrollmentDetails->close();

    // Return success message
    echo json_encode(['success' => true]);
    exit;
} else {
    // Return error message for invalid request
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}
?>

<?php
// Include your database connection file here
include '../php/conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $subjectId = $_POST['subject'];
    $yearLevel = $_POST['year_level'];
    $class = $_POST['class'];
    $semester = $_POST['semester'];
    $facultyId = $_POST['faculty'];

    // Insert assignment details into the database
    $sql = "INSERT INTO faculty_subject_assignment (subject_id, year_level_id, class, semester, faculty_id)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("sssss", $subjectId, $yearLevel, $class, $semester, $facultyId);
    $stmt->execute();

    $stmt->close();

    // Fetch updated assignments
    $sqlFetchAssignments = "SELECT * FROM faculty_subject_assignment";
    $resultAssignments = $conn->query($sqlFetchAssignments);
    $assignments = [];

    if (!$resultAssignments) {
        die("Query failed: " . $conn->error);
    }

    if ($resultAssignments->num_rows > 0) {
        while ($row = $resultAssignments->fetch_assoc()) {
            $assignments[] = $row;
        }
    }

    // Return the updated assignments as JSON
    header('Content-Type: application/json');
    echo json_encode($assignments);
    exit();
}
?>

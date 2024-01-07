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
    $sql = "INSERT INTO faculty_subject_assignment (subject_id, year_level, class, semester, faculty_id)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("sssss", $subjectId, $yearLevel, $class, $semester, $facultyId);
    $stmt->execute();

    $stmt->close();

    // You can redirect to a confirmation page or perform other actions as needed
    header("Location: assignfaculty.php?success=1");
    exit();
}
?>

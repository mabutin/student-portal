<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $enrolledSubjectId = mysqli_real_escape_string($conn, $_POST['enrolled_subject_id']);
    $columnName = mysqli_real_escape_string($conn, $_POST['column_name']);
    $newValue = mysqli_real_escape_string($conn, $_POST['new_value']);

    // Update the database
    $updateQuery = "UPDATE enrolled_subjects SET $columnName = ? WHERE enrolled_subject_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $newValue, $enrolledSubjectId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "Database updated successfully.";
    } else {
        echo "Failed to prepare statement: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}
?>

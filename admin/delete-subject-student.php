<?php
header('Access-Control-Allow-Origin: *');

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

include '../php/conn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enrolled_subject_id'])) {
    $enrolled_subject_id = mysqli_real_escape_string($conn, $_POST['enrolled_subject_id']);

    // Debugging statement
    echo "Received enrolled_subject_id: " . $enrolled_subject_id;

    $delete_query = "DELETE FROM enrolled_subjects WHERE enrolled_subject_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);

    if ($delete_stmt) {
        mysqli_stmt_bind_param($delete_stmt, "i", $enrolled_subject_id);
        mysqli_stmt_execute($delete_stmt);

        if (mysqli_stmt_affected_rows($delete_stmt) > 0) {
            echo "Subject deleted successfully";
        } else {
            echo "Failed to delete subject";
        }

        mysqli_stmt_close($delete_stmt);
    } else {
        echo "Error in preparing delete statement";
    }
} else {
}

mysqli_close($conn);
?>

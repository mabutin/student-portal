<?php
include '../php/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $openSubjectsId = $_GET['id'];

    $deleteQuery = "DELETE FROM open_subjects WHERE open_subject_id = $openSubjectsId";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        header("Location: manage-subject.php"); 
        exit();
    } else {
        echo "Error deleting subject from open_subjects: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

mysqli_close($conn);
?>

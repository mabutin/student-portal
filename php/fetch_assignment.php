<?php
include '../php/conn.php';

// Fetch assignments for display
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

// Return assignments as JSON
header('Content-Type: application/json');
echo json_encode($assignments);
exit();
?>

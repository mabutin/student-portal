<?php
// update_subjects.php

include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch selected values from the AJAX request
    $selectedCourse = isset($_POST['course']) ? $_POST['course'] : null;
    $selectedYearLevel = isset($_POST['yearLevel']) ? $_POST['yearLevel'] : null;

    // Check if the selected values are not null
    if ($selectedCourse !== null && $selectedYearLevel !== null) {
        // Fetch updated subjects based on the selected course and year level
        $sql = "SELECT os.open_subject_id, s.subject_id, s.code, s.name, s.unit
                FROM open_subjects os
                JOIN subjects s ON os.subject_id = s.subject_id
                WHERE os.course_id = ? AND os.year_level_id = ? AND os.semester_tbl_id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error in SQL query: " . $conn->error);
        }

        // Assuming you have a column 'semester_tbl_id' in your 'open_subjects' table
        $currentMonth = date('n');
        $selectedSemester = ($currentMonth >= 7 && $currentMonth <= 12) ? 2 : 1;

        $stmt->bind_param("iii", $selectedCourse, $selectedYearLevel, $selectedSemester);
        $stmt->execute();

        if ($stmt->error) {
            die("Error in query execution: " . $stmt->error);
        }

        $result = $stmt->get_result();

        // Output the updated subject table structure
        echo "<table class='table-auto w-full'>
                <thead>
                    <tr class='justify-between bg-blue-200'>
                        <td style='width: 20%;' class='text-center'>Code</td>
                        <td style='width: 50%;' class='text-center'>Subject</td>
                        <td style='width: 30%;' class='text-center'>Units</td>
                    </tr>
                </thead>
                <tbody>";

        if ($result->num_rows > 0) {
            // Iterate through the table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td class='pl-16 hidden'><input type=\"text\" name=\"enrolled_subjects[]\" value=\"{$row['subject_id']}\"></td>
                        <td class='pl-16'>{$row['code']}</td>
                        <td class='text-center'>{$row['name']}</td>
                        <td class='text-center'>{$row['unit']}</td>
                    </tr>";
            }
        } else {
            // Output a message if no subjects are found
            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
        }

        // Close the table structure
        echo "</tbody></table>";

        $stmt->close();
    } else {
        // Output an error message if selected values are not provided
        echo "Invalid parameters";
    }

    mysqli_close($conn);
} else {
    // Output an error message if the request method is not POST
    echo "Invalid request method";
}
?>

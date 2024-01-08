<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'guest';

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

    // Redirect to prevent form resubmission
    header("Location: assignfaculty.php");
    exit();
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Assign Faculty</title>
    <script>
        function updateClasses() {
            var yearLevelSelect = document.getElementById('year_level');
            var classSelect = document.getElementById('class');

            // Get the selected year level value
            var yearLevelValue = yearLevelSelect.value;

            // Fetch classes from the server based on the selected year level
            var url = 'fetch_classes.php?year_level=' + yearLevelValue;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update the class dropdown with the fetched classes
                    classSelect.innerHTML = ''; // Clear existing options
                    if (data.length > 0) {
                        data.forEach(className => {
                            var option = document.createElement('option');
                            option.value = className;
                            option.textContent = className;
                            classSelect.appendChild(option);
                        });
                    } else {
                        var option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No classes available';
                        classSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching classes:', error);
                });
        }

        function updateTable() {
            // Fetch assignments from the server
            fetch('../admin/process_assignment.php')  // Corrected URL
                .then(response => response.json())
                .then(data => {
                    // Update the assignments table with the fetched data
                    var assignmentsTable = document.getElementById('assignments_table');
                    var tbody = assignmentsTable.querySelector('tbody');

                    // Clear existing rows
                    tbody.innerHTML = '';

                    // Add new rows based on the fetched data
                    data.forEach(assignment => {
                        var row = document.createElement('tr');

                        var columns = ['assignment_id', 'subject_id', 'year_level_id', 'class', 'semester', 'faculty_id'];

                        columns.forEach(column => {
                            var cell = document.createElement('td');
                            cell.textContent = assignment[column];
                            row.appendChild(cell);
                        });

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching assignments:', error);
                });
        }

        function submitForm(event) {
            event.preventDefault();

            // Form data
            var formData = new FormData(event.target);

            // Submit form data using fetch
            fetch('../admin/process_assignment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Update the assignments table with the new data
                updateTable();
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
        }
    </script>
</head>

<body class="font-serif">
    <form onsubmit="submitForm(event)">
        <div class="flex">
            <div>
                <?php include './sidebar.php'; ?>
            </div>
            <div class="w-full py-4 px-4">
                <div>
                    <?php include './topbar.php'; ?>
                </div>

                <section>
                    <h2>Assign Faculty to Subject</h2>

                    <!-- Subject Selection -->
                    <label for="subject">Select Subject:</label>
                    <select name="subject" required>
                        <?php
                        // Fetch subjects from the database
                        $sqlSubjects = "SELECT subject_id, name FROM subjects";
                        $resultSubjects = $conn->query($sqlSubjects);

                        if ($resultSubjects->num_rows > 0) {
                            while ($row = $resultSubjects->fetch_assoc()) {
                                echo "<option value='" . $row['subject_id'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No subjects available</option>";
                        }

                        $resultSubjects->close();
                        ?>
                    </select>

                    <!-- Year Level Selection -->
                    <label for="year_level">Select Year Level:</label>
                    <select name="year_level" id="year_level" onchange="updateClasses()" required>
                        <?php
                        // Fetch year levels from the database
                        $sqlYearLevels = "SELECT year_level_id, year_level FROM year_level";
                        $resultYearLevels = $conn->query($sqlYearLevels);

                        if ($resultYearLevels->num_rows > 0) {
                            while ($row = $resultYearLevels->fetch_assoc()) {
                                echo "<option value='" . $row['year_level_id'] . "'>" . $row['year_level'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No year levels available</option>";
                        }

                        $resultYearLevels->close();
                        ?>
                    </select>

                    <!-- Class Selection -->
                    <label for="class">Select Class:</label>
                    <select name="class" id="class" required>
                        <option value="">Select a Year Level first</option>
                    </select>

                    <!-- Semester Selection -->
                    <label for="semester">Select Semester:</label>
                    <select name="semester" required>
                        <option value="1">First Semester</option>
                        <option value="2">Second Semester</option>
                        <!-- Add more options as needed -->
                    </select>

                    <!-- Faculty Member Selection -->
                    <label for="faculty">Select Faculty Member:</label>
                    <select name="faculty" required>
                        <?php
                        // Fetch faculty members from the database
                        $sqlFaculty = "SELECT professor_details_id, surname, first_name, middle_name FROM professor_details";
                        $resultFaculty = $conn->query($sqlFaculty);

                        if ($resultFaculty->num_rows > 0) {
                            while ($row = $resultFaculty->fetch_assoc()) {
                                echo "<option value='" . $row['professor_details_id'] . "'>" . $row['surname'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No faculty members available</option>";
                        }

                        $resultFaculty->close();
                        ?>
                    </select>

                    <!-- Submit Button -->
                    <button type="submit">Assign Faculty</button>
                </section>
            </div>
        </div>
    </form>

    <!-- Display Assignments Table -->
    <section>
        <h2>Assigned Faculty</h2>
        <table id="assignments_table">
            <thead>
                <tr>
                    <th>Assignment ID</th>
                    <th>Subject ID</th>
                    <th>Year Level</th>
                    <th>Class</th>
                    <th>Semester</th>
                    <th>Faculty ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $assignment) : ?>
                    <tr>
                        <td><?= $assignment['assignment_id'] ?></td>
                        <td><?= $assignment['subject_id'] ?></td>
                        <td><?= $assignment['year_level_id'] ?></td>
                        <td><?= $assignment['class'] ?></td>
                        <td><?= $assignment['semester'] ?></td>
                        <td><?= $assignment['faculty_id'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <script src="../assets/js/studentSidebar.js"></script>
</body>

</html>

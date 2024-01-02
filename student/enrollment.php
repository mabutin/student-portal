<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, ed.course, si.profile_picture
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
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

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $course = $row['course'];
    $suffix = $row['suffix'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

// Fetch distinct years from the subject table
$sql_years = "SELECT DISTINCT year FROM subject";
$result_years = $conn->query($sql_years);

if ($result_years) {
    $years = [];
    while ($row_years = $result_years->fetch_assoc()) {
        $years[] = $row_years['year'];
    }
}

// Fetch distinct courses from the subject table
$sql_courses = "SELECT DISTINCT course FROM subject";
$result_courses = $conn->query($sql_courses);

if ($result_courses) {
    $courses = [];
    while ($row_courses = $result_courses->fetch_assoc()) {
        $courses[] = $row_courses['course'];
    }
}

$sql_courses = "SELECT DISTINCT course FROM subject";
$result_courses = $conn->query($sql_courses);

if ($result_courses) {
    $courses = [];
    while ($row_courses = $result_courses->fetch_assoc()) {
        $courses[] = $row_courses['course'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Admission Page</title>
</head>
<body>
    <div style="background: radial-gradient(at center, rgba(118, 163, 224, 0.5  ), #FFFFFF);">
        <div>
            <?php include './topbar.php'; ?>
        </div>
        <div class="w-full"><img src="../assets/img/admission-banner.png" class="w-full" alt=""></div>
        <div class="w-full flex justify-center mt-4 mb-14">
            <div class="container mx-auto mt-8 p-4 font-semibold mb-4 max-w-6xl shadow-2xl rounded-md bg-white">
                <div class="text-4xl font-bold text-center mb-8">CURRICULUM</div>

                <div class="flex mb-4 space-x-4">
                    <div class="flex items-center">
                        <label for="yearFilter" class="mr-2">Filter by Year:</label>
                        <select id="yearFilter" class="border border-gray-300 px-2 py-1 rounded" onchange="filterTable()">
                          
                            <?php foreach ($years as $year) : ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <label for="courseFilter" class="mr-2">Filter by Course:</label>
                        <select id="courseFilter" class="border border-gray-300 px-2 py-1 rounded" onchange="filterTable()">
                            <?php foreach ($courses as $course) : ?>
                                <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <label for="semesterFilter" class="mr-2">Filter by Semester:</label>
                        <select id="semesterFilter" class="border border-gray-300 px-2 py-1 rounded" onchange="filterTable()">
                        <?php foreach ($semesters as $semesters) : ?>
                                <option value="<?php echo $semesters; ?>"><?php echo $semesters; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php
                // Query to retrieve data from the "subject" table
                $sql_subjects = "SELECT * FROM subject";
                $result_subjects = $conn->query($sql_subjects);

                // Check if there are results
                if ($result_subjects->num_rows > 0) :
                    mysqli_data_seek($result_subjects, 0); // Reset result set pointer
                ?>
                    <div>
                        <table id="data-table">
                            <thead>
                                <tr>
                                    <th>Subject ID</th>
                                    <th>Subject Name</th>
                                    <th>Subject Code</th>
                                    <th>Subject Unit</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_subjects = $result_subjects->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["subject_id"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["sub_name"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["sub_code"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["sub_unit"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["course"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["semester"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $row_subjects["year"]; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center">0 results</p>
                <?php endif; ?>

                <!-- Close the database connection -->
                <?php $conn->close(); ?>
                
                <script>
                    function filterTable() {
                        var yearFilter = document.getElementById('yearFilter').value;
                        var courseFilter = document.getElementById('courseFilter').value;
                        var semesterFilter = document.getElementById('semesterFilter').value;

                        var table = document.getElementById('data-table');
                        var rows = table.getElementsByTagName('tr');

                        for (var i = 1; i < rows.length; i++) {
                            var yearCell = rows[i].getElementsByTagName('td')[6].innerText.trim(); // Change 6 to the correct column index
                            var courseCell = rows[i].getElementsByTagName('td')[4].innerText.trim(); // Change 4 to the correct column index
                            var semesterCell = rows[i].getElementsByTagName('td')[5].innerText.trim(); // Change 5 to the correct column index

                            // Add this condition to filter by selected year
                            var showRow = (yearFilter === '' || yearCell === yearFilter) &&
                                (courseFilter === '' || courseCell === courseFilter) &&
                                (semesterFilter === '' || semesterCell === semesterFilter);

                            rows[i].style.display = showRow ? '' : 'none';
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    <script src="../assets/js/enrollment-menu.js"></script>
</body>
</html>

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
                        <option value="">All</option>
                        <?php foreach ($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="courseFilter" class="mr-2">Filter by Course:</label>
                    <select id="courseFilter" class="border border-gray-300 px-2 py-1 rounded" onchange="filterTable()">
                        <option value="">All</option>
                        <?php foreach ($courses as $course) : ?>
                            <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="semesterFilter" class="mr-2">Filter by Semester:</label>
                    <select id="semesterFilter" class="border border-gray-300 px-2 py-1 rounded" onchange="filterTable()">
                        <option value="">All</option>
                        <?php foreach ($semesters as $semester) : ?>
                            <option value="<?php echo $semester; ?>"><?php echo $semester; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($result->num_rows > 0) : ?>
                <div class='flex flex-col items-center'>
                    <table id='data-table' class='border border-collapse border-2 w-full bg-white shadow-md'>
                        <thead class='bg-gray-200'>
                        <tr>
                            <th class='border px-4 py-2'>ID</th>
                            <th class='border px-4 py-2'>Name</th>
                            <th class='border px-4 py-2'>Code</th>
                            <th class='border px-4 py-2'>Unit</th>
                            <th class='border px-4 py-2'>Course</th>
                            <th class='border px-4 py-2'>Semester</th>
                            <th class='border px-4 py-2'>Year</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        mysqli_data_seek($result, 0); // Reset result set pointer
                        while ($row = $result->fetch_assoc()) :
                            ?>
                            <tr>
                                <td class='border px-4 py-2'><?php echo $row["sub_id"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["sub_name"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["sub_code"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["sub_unit"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["course"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["semester"]; ?></td>
                                <td class='border px-4 py-2'><?php echo $row["year"]; ?></td>
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
                        var yearCell = rows[i].getElementsByTagName('td')[6].innerText;
                        var courseCell = rows[i].getElementsByTagName('td')[4].innerText;
                        var semesterCell = rows[i].getElementsByTagName('td')[5].innerText;

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

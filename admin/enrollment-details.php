<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    $query = "SELECT sn.student_number, s.surname, s.first_name, s.middle_name, s.suffix, ed.course_id, yl.year_level, cr.course_name, si.status, s.suffix
    FROM student_information si
    JOIN students s ON si.student_id = s.student_id
    JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
    JOIN course cr ON ed.course_id = cr.course_id
    JOIN year_level yl ON ed.year_level_id = yl.year_level_id
    JOIN student_number sn ON s.student_number_id = sn.student_number_id
WHERE 
    sn.student_number = ?";



    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $student_details = mysqli_fetch_assoc($result);
        } else {
            die("Query failed: " . mysqli_error($conn));
        }
    } else {
        die("Prepare statement failed: " . mysqli_error($conn));
    }
    $stmt->close();
}
$student_id1 = 84;
$sql = "SELECT
            students.students_id,
            students.surname,
            students.first_name,
            students.middle_name,
            students.suffix,
            enrolled_subject.enrolled_subject_id,
            subject.sub_name,
            subject.sub_code,
            subject.sub_unit,
            subject.course,
            subject.semester,
            subject.year
        FROM
            students
        JOIN enrolled_subject ON students.students_id = enrolled_subject.students_id
        JOIN subject ON enrolled_subject.subject_id = subject.sub_id
        WHERE
            students.students_id = $student_id1";

$result1 = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-[roboto-serif]">
    <div class="mt-4">
        <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold">
            <div class="flex justify-between items-center gap-2">
                <div class="w-full flex justify-between items-center gap-2">
                    <div class="flex justify-start items-center gap-2">
                        <a href="./enrollment-list.php" aria-label="Go back" id="goBackButton">
                            <img src="../assets/svg/back.svg" style="width: 24px; height: 24px; transition: width 0.3s, height 0.3s;" alt="Go back">
                        </a>
                        <div class="flex justify-start items-center gap-2">
                            Enrollment Details
                        </div>
                    </div>
                    <button onClick="printStudentDetails();" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">
                        Print
                    </button>
                </div>
            </div>
            <?php if (isset($student_details)) : ?>
                <div class="flex gap-4 h-full" id='printable_div_id'>
                    <div id="studentDetailsContainer" class="py-10  px-12 h-full">
                        <div class="flex justify-start items-start gap-8">
                            <div>
                                <?php if (empty($student_details['profile_picture'])) : ?>
                                    <img src="../assets/svg/profile.svg" class="w-48 h-48" alt="">
                                <?php else : ?>
                                    <img src="<?= $student_details['profile_picture'] ?>" class="w-48 h-48" alt="">
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="flex justify-center mb-5">
                                    <img src="../assets/svg/ollclogo.svg" class="h-20" alt="">
                                </div>
                                <div class="justify-between items-center my-2">
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Student Number:</span>
                                        <span><?= $student_details['student_number'] ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Name:</span>
                                        <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name'] ?>.<?= $student_details['suffix'] ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Course:</span>
                                        <span><?= $student_details['course'] ?></li></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Year Level:</span>
                                        <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid flex justify-center items-center">
                            <div class="mt-8">
                                <h2 class="text-lg font-semibold mb-4">Enrolled Subjects</h2>
                                <table class="w-full border border-gray-300">
                                    <thead>
                                        <tr>
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
                                        while ($row = $result1->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$row['sub_name']}</td>
                                                <td>{$row['sub_code']}</td>
                                                <td>{$row['sub_unit']}</td>
                                                <td>{$row['course']}</td>
                                                <td>{$row['semester']}</td>
                                                <td>{$row['year']}</td>
                                              </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
    <?php else : ?>
        <p>No student details found for the specified ID.</p>
    <?php endif; ?>
    </div>
</body>

</html>
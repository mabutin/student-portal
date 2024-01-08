<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

$student_details = null;
$enrolled_subjects = null;

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    $query = "SELECT
        sn.student_number, sa.school_account_id, sn.student_number_id,
        st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture,
        ed.course_id,
        cr.course_name,
        yl.year_level,
        ed.school_year,
        stbl.semester
    FROM 
        student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.student_id = st.student_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN course cr ON ed.course_id = cr.course_id
        JOIN semester_tbl stbl ON ed.semester_tbl_id = stbl.semester_tbl_id
        JOIN year_level yl ON ed.year_level_id = yl.year_level_id
    WHERE 
        sn.student_number = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $student_details = mysqli_fetch_assoc($result);

            $enrolled_subjects_query = "SELECT 
                                            yl.year_level, 
                                            stbl.semester, 
                                            sbj.code, 
                                            sbj.name, 
                                            sbj.unit
                                        FROM 
                                            students
                                            JOIN enrolled_subjects ON students.student_id = enrolled_subjects.student_id
                                            JOIN subjects sbj ON enrolled_subjects.subject_id = sbj.subject_id
                                            JOIN student_number ON students.student_number_id = student_number.student_number_id
                                            JOIN year_level yl ON enrolled_subjects.year_level_id = yl.year_level_id
                                            JOIN semester_tbl stbl ON enrolled_subjects.semester_tbl_id = stbl.semester_tbl_id
                                        WHERE student_number.student_number = ?";

            $enrolled_subjects_stmt = mysqli_prepare($conn, $enrolled_subjects_query);

            if ($enrolled_subjects_stmt) {
                mysqli_stmt_bind_param($enrolled_subjects_stmt, "s", $student_id);
                mysqli_stmt_execute($enrolled_subjects_stmt);
                $enrolled_subjects_result = mysqli_stmt_get_result($enrolled_subjects_stmt);

                if ($enrolled_subjects_result) {
                    $enrolled_subjects = mysqli_fetch_all($enrolled_subjects_result, MYSQLI_ASSOC);
                } else {
                    die("Enrolled subjects query failed: " . mysqli_error($conn));
                }

                mysqli_stmt_close($enrolled_subjects_stmt);
            } else {
                die("Prepare statement for enrolled subjects failed: " . mysqli_error($conn));
            }
        } else {
            die("Query failed: " . mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Prepare statement failed: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
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
                            <span class="text-xl font-bold">Student Details</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="location.href='edit-enrollment-details.php?student_id=<?= $student_id ?>'" class="px-2 py-1 bg-yellow-300 rounded-md text-sm text-black hover:text-white hover:bg-yellow-500">
                            Edit
                        </button>
                        <button onclick="location.href='registration-card.php?student_id=<?= $student_id ?>'" class="px-2 py-1  bg-green-300 rounded-md text-sm text-black hover:text-white hover:bg-green-500">
                            Registration Card
                        </button>
                        <button onClick="printStudentDetails();" class="px-2 py-1 text-sm bg-blue-500 rounded-md  text-white hover:bg-blue-700">
                            Print
                        </button>
                    </div>
                </div>
            </div>

            <?php if ($student_details): ?>
                <div class="flex gap-4 mt-8" id='printable_div_id'>
                    <div id="studentDetailsContainer" class="py-10 px-12">
                        <div class="flex justify-start items-start gap-8">
                            <?php if (empty($student_details['profile_picture'])): ?>
                                <img src="../assets/svg/profile.svg" class="w-48 h-48" alt="Profile Picture">
                            <?php else: ?>
                                <?php
                                $profilePicturePath = htmlspecialchars($student_details['profile_picture']);
                                $profilePicturePath = str_replace("../student/", "", $profilePicturePath);
                                $fullImagePath = "../student/" . $profilePicturePath;
                                ?>
                                <img src="<?= $fullImagePath ?>" class="w-48 h-48" alt="Profile Picture">
                            <?php endif; ?>
                            <div>
                                <div class="flex justify-center mb-5">
                                    <img src="../assets/svg/ollclogo.svg" class="h-20" alt="OLL logo">
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="font-bold text-gray-600">Student Number:</span>
                                        <span><?= $student_details['student_number'] ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold text-gray-600">Name:</span>
                                        <span><?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name'] ?>.<?= $student_details['suffix'] ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold text-gray-600">Course:</span>
                                        <span><?= $student_details['course_name'] ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold text-gray-600">Year Level:</span>
                                        <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $currentYear = null; ?>
                        <?php foreach ($enrolled_subjects as $subject): ?>
                            <?php if ($currentYear !== $subject['year_level']): ?>
                                <?php if ($currentYear !== null && (count($firstSemesterSubjects) > 0 || count($secondSemesterSubjects) > 0)): ?>
                                    <div class="flex mt-4">
                                        <?php if (!empty($firstSemesterSubjects)): ?>
                                            <div class="w-1/2 pr-4">
                                                <h3 class="text-lg font-bold">First Semester - <?= $currentYear ?></h3>
                                                <table class="table-auto w-full mt-2">
                                                    <thead>
                                                        <tr class="bg-blue-200">
                                                            <th class="px-2 py-1 text-sm">Code</th>
                                                            <th class="px-2 py-1 text-sm">Name</th>
                                                            <th class="px-2 py-1 text-sm">Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($firstSemesterSubjects as $firstSemesterSubject): ?>
                                                            <tr>
                                                                <td class="border px-2 py-1 text-sm"><?= $firstSemesterSubject['code'] ?></td>
                                                                <td class="border px-2 py-1 text-sm"><?= $firstSemesterSubject['name'] ?></td>
                                                                <td class="border px-2 py-1 text-sm text-center"><?= $firstSemesterSubject['unit'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($secondSemesterSubjects)): ?>
                                            <div class="w-1/2 pl-4">
                                                <h3 class="text-lg font-bold">Second Semester - <?= $currentYear ?></h3>
                                                <table class="table-auto w-full mt-2">
                                                    <thead>
                                                        <tr class="bg-blue-200">
                                                            <th class="px-2 py-1 text-sm">Code</th>
                                                            <th class="px-2 py-1 text-sm">Name</th>
                                                            <th class="px-2 py-1 text-sm">Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($secondSemesterSubjects as $secondSemesterSubject): ?>
                                                            <tr>
                                                                <td class="border px-2 py-1 text-sm"><?= $secondSemesterSubject['code'] ?></td>
                                                                <td class="border px-2 py-1 text-sm"><?= $secondSemesterSubject['name'] ?></td>
                                                                <td class="border px-2 py-1 text-sm text-center"><?= $secondSemesterSubject['unit'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php $currentYear = $subject['year_level']; ?>
                                <?php $firstSemesterSubjects = []; ?>
                                <?php $secondSemesterSubjects = []; ?>
                            <?php endif; ?>

                            <?php if ($subject['semester'] === 'First Semester'): ?>
                                <?php $firstSemesterSubjects[] = $subject; ?>
                            <?php elseif ($subject['semester'] === 'Second Semester'): ?>
                                <?php $secondSemesterSubjects[] = $subject; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if ($currentYear !== null && (count($firstSemesterSubjects) > 0 || count($secondSemesterSubjects) > 0)): ?>
                            <div class="flex mt-4">
                                <?php if (!empty($firstSemesterSubjects)): ?>
                                    <div class="w-1/2 pr-4">
                                        <h3 class="text-lg font-bold">First Semester - <?= $currentYear ?></h3>
                                        <table class="table-auto w-full mt-2">
                                            <thead>
                                                <tr class="bg-blue-200">
                                                    <th class="px-2 py-1 text-sm">Code</th>
                                                    <th class="px-2 py-1 text-sm">Name</th>
                                                    <th class="px-2 py-1 text-sm">Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($firstSemesterSubjects as $firstSemesterSubject): ?>
                                                    <tr>
                                                        <td class="border px-2 py-1 text-sm"><?= $firstSemesterSubject['code'] ?></td>
                                                        <td class="border px-2 py-1 text-sm"><?= $firstSemesterSubject['name'] ?></td>
                                                        <td class="border px-2 py-1 text-sm text-center"><?= $firstSemesterSubject['unit'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($secondSemesterSubjects)): ?>
                                    <div class="w-1/2 pl-4">
                                        <h3 class="text-lg font-bold">Second Semester - <?= $currentYear ?></h3>
                                        <table class="table-auto w-full mt-2">
                                            <thead>
                                                <tr class="bg-blue-200">
                                                    <th class="px-2 py-1 text-sm">Code</th>
                                                    <th class="px-2 py-1 text-sm">Name</th>
                                                    <th class="px-2 py-1 text-sm">Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($secondSemesterSubjects as $secondSemesterSubject): ?>
                                                    <tr>
                                                        <td class="border px-2 py-1 text-sm"><?= $secondSemesterSubject['code'] ?></td>
                                                        <td class="border px-2 py-1 text-sm"><?= $secondSemesterSubject['name'] ?></td>
                                                        <td class="border px-2 py-1 text-sm text-center"><?= $secondSemesterSubject['unit'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="mt-4 text-gray-600">No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
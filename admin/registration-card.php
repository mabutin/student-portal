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
                            WHERE 
                                student_number.student_number = ?
                                AND stbl.semester = ?";

            $enrolled_subjects_stmt = mysqli_prepare($conn, $enrolled_subjects_query);

            if ($enrolled_subjects_stmt) {
                mysqli_stmt_bind_param($enrolled_subjects_stmt, "ss", $student_id, $student_details['semester']);
                mysqli_stmt_execute($enrolled_subjects_stmt);
                $enrolled_subjects_result = mysqli_stmt_get_result($enrolled_subjects_stmt);

                if ($enrolled_subjects_result) {
                    $enrolled_subjects = mysqli_fetch_all($enrolled_subjects_result, MYSQLI_ASSOC);
                } else {
                    // Handle the error gracefully, log it or display a user-friendly message.
                    die("Enrolled subjects query failed: " . mysqli_error($conn));
                }

                mysqli_stmt_close($enrolled_subjects_stmt);
            } else {
                // Handle the error gracefully, log it or display a user-friendly message.
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
        <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold" style="width: 816px; height: 700px;">
            <div class="flex justify-between items-center gap-2 mb-4">
                <div class="w-full flex justify-between items-center gap-2">
                    <div class="flex justify-start items-center gap-2">
                        <a href="./enrollment-details.php?student_id=<?= $student_id ?>" aria-label="Go back" id="goBackButton">
                            <img src="../assets/svg/back.svg" style="width: 24px; height: 24px; transition: width 0.3s, height 0.3s;" alt="Go back">
                        </a>
                        <div class="flex justify-start items-center gap-2">
                            Registration card
                        </div>
                    </div>
                    <div>
                        <button onclick="location.href='edit-student.php?student_id=<?= $student_id ?>'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                            Edit
                        </button>
                        <button onClick="printRegistration();" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">
                            Print
                        </button>
                    </div>
                </div>
            </div>
            <div id='printable_div_id'>
                <div class="grid grid-cols-2">
                    <div class="border-r border-b border-blue-400 border-dashed p-4">
                        <div class="flex justify-center mb-2">
                            <img src="../assets/svg/ollclogo.svg" class="h-10" alt="">
                        </div>
                        <div class="gap-1 text-center w-full grid text-xs">
                            School Year <?= $student_details['school_year'] ?>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Student Number:</span>
                            <span><?= $student_details['student_number'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Name:</span>
                            <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>.<?= $student_details['suffix'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Course:</span>
                            <span><?= $student_details['course_name'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Year Level:</span>
                            <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Semester:</span>
                            <span><?= isset($student_details['semester']) ? $student_details['semester'] : 'Not enrolled' ?></span>
                        </div>
                        <div>
                            <div class="mt-4">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-xs">Subject Code</th>
                                            <th class="px-4 py-2 text-xs">Subject Name</th>
                                            <th class="px-4 py-2 text-xs">Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrolled_subjects as $subject): ?>
                                            <tr>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['code'] ?></td>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['name'] ?></td>
                                                <td class="border px-2 py-1 text-xs text-center"><?= $subject['unit'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="border border-blue-300 border-solid p-4 mt-2">
                                <table class="table-auto w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 py-1 text-xs text-center" colspan="2">TUITION FEE</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">MISC. FEE</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"><p class="opacity-0">Amount</p></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">OTHER FEES</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">LESS: SCHOLARSHIP/DISCOUNT</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL PAYABLE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">DOWN PAYMENT</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">BALANCE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-l border-b border-blue-400 border-dashed p-4">
                    <div class="flex justify-center mb-2">
                            <img src="../assets/svg/ollclogo.svg" class="h-10" alt="">
                        </div>
                        <div class="gap-1 text-center w-full grid text-xs">
                            School Year <?= $student_details['school_year'] ?>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Student Number:</span>
                            <span><?= $student_details['student_number'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Name:</span>
                            <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>.<?= $student_details['suffix'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Course:</span>
                            <span><?= $student_details['course_name'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Year Level:</span>
                            <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Semester:</span>
                            <span><?= isset($student_details['semester']) ? $student_details['semester'] : 'Not enrolled' ?></span>
                        </div>
                        <div>
                            <div class="mt-4">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-xs">Subject Code</th>
                                            <th class="px-4 py-2 text-xs">Subject Name</th>
                                            <th class="px-4 py-2 text-xs">Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrolled_subjects as $subject): ?>
                                            <tr>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['code'] ?></td>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['name'] ?></td>
                                                <td class="border px-2 py-1 text-xs text-center"><?= $subject['unit'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="border border-blue-300 border-solid p-4 mt-2">
                                <table class="table-auto w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 py-1 text-xs text-center" colspan="2">TUITION FEE</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">MISC. FEE</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"><p class="opacity-0">Amount</p></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">OTHER FEES</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">LESS: SCHOLARSHIP/DISCOUNT</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL PAYABLE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">DOWN PAYMENT</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">BALANCE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-r border-t border-blue-400 border-dashed p-4">
                    <div class="flex justify-center mb-2">
                            <img src="../assets/svg/ollclogo.svg" class="h-10" alt="">
                        </div>
                        <div class="gap-1 text-center w-full grid text-xs">
                            School Year <?= $student_details['school_year'] ?>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Student Number:</span>
                            <span><?= $student_details['student_number'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Name:</span>
                            <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>.<?= $student_details['suffix'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Course:</span>
                            <span><?= $student_details['course_name'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Year Level:</span>
                            <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Semester:</span>
                            <span><?= isset($student_details['semester']) ? $student_details['semester'] : 'Not enrolled' ?></span>
                        </div>
                        <div>
                            <div class="mt-4">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-xs">Subject Code</th>
                                            <th class="px-4 py-2 text-xs">Subject Name</th>
                                            <th class="px-4 py-2 text-xs">Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrolled_subjects as $subject): ?>
                                            <tr>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['code'] ?></td>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['name'] ?></td>
                                                <td class="border px-2 py-1 text-xs text-center"><?= $subject['unit'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="border border-blue-300 border-solid p-4 mt-2">
                                <table class="table-auto w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 py-1 text-xs text-center" colspan="2">TUITION FEE</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">MISC. FEE</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"><p class="opacity-0">Amount</p></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">OTHER FEES</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">LESS: SCHOLARSHIP/DISCOUNT</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL PAYABLE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">DOWN PAYMENT</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">BALANCE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-l border-t border-blue-400 border-dashed p-4">
                    <div class="flex justify-center mb-2">
                            <img src="../assets/svg/ollclogo.svg" class="h-10" alt="">
                        </div>
                        <div class="gap-1 text-center w-full grid text-xs">
                            School Year <?= $student_details['school_year'] ?>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Student Number:</span>
                            <span><?= $student_details['student_number'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Name:</span>
                            <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>.<?= $student_details['suffix'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Course:</span>
                            <span><?= $student_details['course_name'] ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Year Level:</span>
                            <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                        </div>
                        <div class=" flex gap-1 text-xs mt-2">
                            <span class="font-bold">Semester:</span>
                            <span><?= isset($student_details['semester']) ? $student_details['semester'] : 'Not enrolled' ?></span>
                        </div>
                        <div>
                            <div class="mt-4">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-xs">Subject Code</th>
                                            <th class="px-4 py-2 text-xs">Subject Name</th>
                                            <th class="px-4 py-2 text-xs">Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrolled_subjects as $subject): ?>
                                            <tr>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['code'] ?></td>
                                                <td class="border px-2 py-1 text-xs"><?= $subject['name'] ?></td>
                                                <td class="border px-2 py-1 text-xs text-center"><?= $subject['unit'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="border border-blue-300 border-solid p-4 mt-2">
                                <table class="table-auto w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 py-1 text-xs text-center" colspan="2">TUITION FEE</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">MISC. FEE</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"><p class="opacity-0">Amount</p></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">OTHER FEES</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">LESS: SCHOLARSHIP/DISCOUNT</td>
                                            <td class="px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">TOTAL PAYABLE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">DOWN PAYMENT</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1 text-xs">BALANCE</td>
                                            <td class="border px-2 py-1 text-xs border border-blue-300"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        function printRegistration() {
            var printContents = document.getElementById("printable_div_id").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</html>
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
        sn.student_number, sa.school_account_id, sn.student_number_id, st.student_id,
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
                es.enrolled_subject_id,
                sbj.code,
                sbj.name,
                sbj.unit,
                es.prelim,
                es.midterm,
                es.finals,
                (es.prelim + es.midterm + es.finals) as total
            FROM students
            JOIN enrolled_subjects es ON students.student_id = es.student_id
            JOIN subjects sbj ON es.subject_id = sbj.subject_id
            JOIN student_number ON students.student_number_id = student_number.student_number_id
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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                            Student Details
                        </div>
                    </div>
                    <div>
                        <button onclick="location.href='add-new-subject.php?student_id=<?= $student_id ?>'" class="p-2 bg-yellow-300 rounded-md text-xs text-black hover:text-white hover:bg-yellow-500">
                            Add Subject
                        </button>
                    </div>
                </div>
            </div>
            <?php if ($student_details): ?>
                <div class="flex gap-4 h-full" id='printable_div_id'>
                    <div id="studentDetailsContainer" class="py-10 px-12 h-full">
                        <div class="flex justify-start items-start gap-8">
                            <?php if (empty($student_details['profile_picture'])): ?>
                                <img src="../assets/svg/profile.svg" class="w-48 h-48" alt="">
                            <?php else: ?>
                                <?php
                                $profilePicturePath = htmlspecialchars($student_details['profile_picture']);
                                $profilePicturePath = str_replace("../student/", "", $profilePicturePath);
                                $fullImagePath = "../student/" . $profilePicturePath;
                                ?>
                                <img src="<?= $fullImagePath ?>" class="w-48 h-48" alt="">
                            <?php endif; ?>
                            <div>
                                <div class="flex justify-center mb-5">
                                    <img src="../assets/svg/ollclogo.svg" class="h-20" alt="">
                                </div>
                                <div class="justify-between items-center my-2">
                                    <div class="flex gap-1">
                                        <span class="font-bold">Student Number:</span>
                                        <span><?= $student_details['student_number'] ?></span>
                                    </div>
                                    <div class="flex gap-1">
                                        <span class="font-bold">Name:</span>
                                        <span><?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name'] ?>.<?= $student_details['suffix'] ?></span>
                                    </div>
                                    <div class="flex gap-1">
                                        <span class="font-bold">Course:</span>
                                        <span><?= $student_details['course_name'] ?></span>
                                    </div>
                                    <div class="flex gap-1">
                                        <span class="font-bold">Year Level:</span>
                                        <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                                    </div>
                                    <div class="flex gap-1 hidden">
                                        <span class="font-bold">Student Number ID:</span>
                                        <span><?= isset($student_details['student_number_id']) ? $student_details['student_number_id'] : 'Not enrolled' ?></span>
                                    </div>
                                    <div class="flex gap-1 hidden">
                                        <span class="font-bold">Student ID:</span>
                                        <span><input type="text" name="student_id" value="<?= isset($student_details['student_id']) ? $student_details['student_id'] : 'Not enrolled' ?>"></span>
                                        <span><input type="text" name="subject_id" value="<?= isset($subject['subject_id']) ? $subject['subject_id'] : 'N/A' ?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($enrolled_subjects): ?>
                            <div class="mt-4">
                                <h2>Enrolled Subjects</h2>
                                <?= isset($student_details['school_year']) ? $student_details['school_year'] : 'Not enrolled' ?>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="py-2" colspan="3">
                                                <div class="flex gap-1">
                                                    <span class="font-semibold">Year Level:</span>
                                                    <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                                                </div>
                                            </th>
                                            <th>
                                            </th>
                                            <th class="py-2" colspan="3">
                                                <div class="flex gap-1">
                                                    <span class="font-semibold">Semester:</span>
                                                    <span><?= isset($student_details['semester']) ? $student_details['semester'] : 'Not enrolled' ?></span>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="bg-blue-200">
                                            <th class="px-4 py-2" style="width: 3%;">Actions</th>
                                            <th class="px-4 py-2">Code</th>
                                            <th class="px-4 py-2">Name</th>
                                            <th class="px-4 py-2">Units</th>
                                            <th class="px-4 py-2">Prelim</th>
                                            <th class="px-4 py-2">Midterm</th>
                                            <th class="px-4 py-2">Finals</th>
                                            <th class="px-4 py-2">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrolled_subjects as $subject): ?>
                                            <tr>
                                                <td class='text-center'>
                                                    <form action="./delete-subject-student.php" method="POST">
                                                        <button onclick="deleteSubject('<?= $subject['enrolled_subject_id'] ?>')">
                                                            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9 10V44H39V10H9Z" fill="#2F88FF" stroke="black" stroke-width="4" stroke-linejoin="round"/>
                                                                <path d="M20 20V33" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M28 20V33" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M4 10H44" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M16 10L19.289 4H28.7771L32 10H16Z" fill="#2F88FF" stroke="black" stroke-width="4" stroke-linejoin="round"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="hidden" name="enrolled_subject_id[]" value="<?= $subject['enrolled_subject_id'] ?>">
                                                    <?= $subject['code'] ?>
                                                </td>
                                                <td class="border px-4 py-2"><?= $subject['name'] ?></td>
                                                <td class="border px-4 py-2 text-center"><?= $subject['unit'] ?></td>
                                                <td class="border px-4 py-2 editable" data-column="prelim"><?= $subject['prelim'] ?></td>
                                                <td class="border px-4 py-2 editable" data-column="midterm"><?= $subject['midterm'] ?></td>
                                                <td class="border px-4 py-2 editable" data-column="finals"><?= $subject['finals'] ?></td>
                                                <td class="border px-4 py-2 editable" data-column="total"><?= $subject['total'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p>No enrolled subjects found for the specified student.</p>
                        <?php endif; ?>
                    </div>          
                </div>
            <?php else: ?>
                <p>No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteSubject(enrolledSubjectId) {
        $.ajax({
            type: 'POST',
            url: './delete-subject-student.php',
            data: { enrolled_subject_id: enrolledSubjectId },
            success: function (response) {
                console.log(response);
                window.location.reload();
            },
            error: function () {
                console.error('Error deleting subject');
            }
        });
    }
    $(document).ready(function () {
        function makeCellEditable(cell) {
            var originalContent = cell.text();

            cell.html('<input type="text" class="editable-cell" value="' + originalContent + '">');

            cell.find('.editable-cell').focus();

            cell.find('.editable-cell').blur(function () {
                var newValue = $(this).val();

                cell.text(newValue);

                var enrolledSubjectId = cell.closest('tr').find('input[name="enrolled_subject_id[]"]').val();
                var columnName = cell.attr('data-column');

                updateDatabase(enrolledSubjectId, columnName, newValue);

                cell.dblclick(function () {
                    makeCellEditable(cell);
                });
            });

            cell.off('dblclick');
        }

        $('.editable').dblclick(function () {
            makeCellEditable($(this));
        });

        function updateDatabase(enrolledSubjectId, columnName, newValue) {
            $.ajax({
                type: 'POST',
                url: './update-grades.php',
                data: {
                    enrolled_subject_id: enrolledSubjectId,
                    column_name: columnName,
                    new_value: newValue
                },
                success: function (response) {
                    console.log(response);
                },
                error: function () {
                    console.error('Error updating database');
                }
            });
        }
    })
</script>


</body>

</html>
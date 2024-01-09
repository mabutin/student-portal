<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}
include '../php/conn.php';
$usertype = $_SESSION['usertype'] ?? 'guest';

function getCurrentSchoolYearAndSemester() {
    $currentMonth = date('n');
    $startMonth = ($currentMonth >= 7) ? 7 : 1;
    $startYear = ($currentMonth >= 7) ? date('Y') : date('Y') - 1;
    $endYear = $startYear + 1;
    $semester = ($currentMonth >= 7 && $currentMonth <= 12) ? 'First Semester' : 'Second Semester';
    $schoolYear = $startYear . '-' . $endYear;
    return array('schoolYear' => $schoolYear, 'semester' => $semester);
}

$schoolInfo = getCurrentSchoolYearAndSemester();
// echo "Debug: School Year Info - ";
// print_r($schoolInfo);

$schoolYear = $schoolInfo['schoolYear'];
$semester = $schoolInfo['semester'];

$semesterMapping = [
    'First Semester' => 1,
    'Second Semester' => 2,
];
$semesterId = $semesterMapping[$semester] ?? 0;

if (isset($_POST['saveSubjects'])) {
    $studentId = $_POST['studentId'] ?? 0; 
    $yearlevelId = $_POST['yearlevelId'] ?? 0; 

    if (isset($_POST['selectedSubjects']) && is_array($_POST['selectedSubjects'])) {
        $selectedSubjects = $_POST['selectedSubjects'];

        include '../php/conn.php';

        foreach ($selectedSubjects as $subjectId) {
            echo "Current values: student_id=$studentId, subject_id=$subjectId, year_level_id=$yearlevelId, semester_tbl_id=$semesterId<br>";
        
            $insertQuery = "INSERT INTO enrolled_subjects (student_id, subject_id, year_level_id, semester_tbl_id, school_year) 
                VALUES (?, ?, ?, ?, ?)";
        
            $insertStmt = mysqli_prepare($conn, $insertQuery);
        
            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, 'iiiss', $studentId, $subjectId, $yearlevelId, $semesterId, $schoolYear);
        
        
                if (mysqli_stmt_execute($insertStmt)) {
                    header("Location: enrollment-list.php");
                    exit(); // Added exit to stop further execution after header redirect
                } else {
                    echo "Debug: Insertion failed<br>";
                    echo "Error adding subject with ID $subjectId: " . mysqli_error($conn) . "<br>";
                }
        
                echo "Debug: After insertion<br>";
        
                mysqli_stmt_close($insertStmt);
            } else {
                echo "Insert statement preparation failed: " . mysqli_error($conn) . "<br>";
                exit(); // Added exit to stop further execution after error
            }
        }
        
        mysqli_close($conn);

        echo "Selected subjects have been added for the student.";
        exit(); 
    } else {
        echo "Please select at least one subject.";
        exit(); 
    }
}
$courseId = null;

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    $query = "SELECT
        st.student_id,
        st.surname,  
        cr.course_id,
        cr.course_name,
        s.code,
        s.name,
        s.unit,
        s.subject_id,
        ed.year_level_id
    FROM 
        student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN course cr ON ed.course_id = cr.course_id
        JOIN students st ON st.student_number_id = sn.student_number_id
        LEFT JOIN subjects s ON cr.course_id = s.course_id
    WHERE 
        sn.student_number = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $student_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $courseId = $row['course_id']; 
                $students_id = $row['student_id'];
                $yearLevelId = $row['year_level_id'];
            }
        } else {
            echo "Query execution failed: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Query preparation failed: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Open Subjects</title>
</head>

<body class="font-[roboto-serif]">
    <div class="flex justify-start">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
            <form action="" method="post">
                <input type='hidden' name='studentId' value='<?php echo $students_id; ?>' />
                <input type='hidden' name='yearlevelId' value='<?php echo $yearLevelId; ?>' />
                <div class="mt-4 table-container overflow-y-auto" style="height: 860px; width:fit-content">
                    <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-start items-center gap-2">
                                <button type="button" onclick="location.href='edit-enrollment-details.php?student_id=<?= $student_id ?>'" aria-label="Go back" id="goBackButton">
                                    <img src="../assets/svg/back.svg" style="width: 24px; height: 24px; transition: width 0.3s, height 0.3s;" alt="Go back">
                                </button>
                                <span>
                                    Open Subjects for <?php echo $schoolYear; ?> - <?php echo $semester; ?>
                                </span>
                            </div>
                            <div class="flex items-center justify-between px-4 gap-4">
                                <div class="hidden">
                                    <input type="checkbox" name="saveAsDefault"> Save as default
                                </div>
                                <div class="flex items-center justify-center gap-4">
                                    <button class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600" type="submit" name="saveSubjects">Save</button>
                                </div>
                            </div>
                        </div>
                        <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                include '../php/conn.php';

                                if (isset($_GET['student_id'])) {
                                    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

                                    $query = "SELECT
                                        st.student_id,
                                        cr.course_id,
                                        cr.course_name,
                                        s.code,
                                        s.name,
                                        s.unit,
                                        s.subject_id,
                                        ed.year_level_id
                                    FROM 
                                        student_number sn 
                                        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
                                        JOIN student_information si ON sa.school_account_id = si.school_account_id
                                        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
                                        JOIN course cr ON ed.course_id = cr.course_id
                                        JOIN students st ON st.student_id = si.student_id
                                        LEFT JOIN subjects s ON cr.course_id = s.course_id
                                    WHERE 
                                        sn.student_number = ?";

                                    $stmt = mysqli_prepare($conn, $query);

                                    if ($stmt) {
                                        mysqli_stmt_bind_param($stmt, 's', $student_id);
                                        mysqli_stmt_execute($stmt);

                                        $result = mysqli_stmt_get_result($stmt);

                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $subject_id = $row['subject_id'];
                                                $student_id = $row['student_id'];
                                                $year_level_id = $row['year_level_id'];
                                                $code = $row['code'];
                                                $name = $row['name'];
                                                $unit = $row['unit'];

                                                echo "<tr>
                                                        <td class='px-6 py-4 whitespace-nowrap'>$code</td>
                                                        <td class='px-6 py-4 whitespace-nowrap'>$name</td>
                                                        <td class='px-6 py-4 whitespace-nowrap'>$unit</td>
                                                        <td class='px-6 py-4 whitespace-nowrap'>
                                                            <input type='checkbox' name='selectedSubjects[]' value='$subject_id' />
                                                        </td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "Query execution failed: " . mysqli_error($conn);
                                        }

                                        mysqli_stmt_close($stmt);
                                    } else {
                                        echo "Query preparation failed: " . mysqli_error($conn);
                                    }

                                    mysqli_close($conn);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
</body>

</html>

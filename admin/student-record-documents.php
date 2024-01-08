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

    $query = "SELECT
    sn.student_number, sa.school_account_id,
    st.first_name, st.surname, st.middle_name, st.suffix, si.profile_picture,
    ed.course_id, cr.course_name, yl.year_level,
    ci.city, ci.address,
    pi.gender, pi.birthday, pi.birth_place, pi.citizenship,
    e.year AS elementary_year, e.name AS elementary_name,
    jh.year AS junior_high_year, jh.name AS junior_high_name,
    sh.year AS senior_high_year, sh.name AS senior_high_name
    
FROM 
    student_number sn 
    JOIN school_account sa ON sn.student_number_id = sa.student_number_id
    JOIN student_information si ON sa.school_account_id = si.school_account_id
    JOIN students st ON si.student_id = st.student_id
    JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
    JOIN course cr ON ed.course_id = cr.course_id
    JOIN year_level yl ON ed.year_level_id = yl.year_level_id
    JOIN personal_information pi ON si.personal_information_id = pi.personal_information_id
    JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
    JOIN educational_attainment ea ON si.educational_attainment_id = ea.educational_attainment_id
    JOIN elementary e ON ea.elementary_id = e.elementary_id
    JOIN junior_high jh ON ea.junior_high_id = jh.junior_high_id
    JOIN senior_high sh ON ea.senior_high_id = sh.senior_high_id
    
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

        mysqli_stmt_close($stmt);
    } else {
        die("Prepare statement failed: " . mysqli_error($conn));
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" href="../assets/css/student-record-documents.css">

</head>

<body> <!-- roboto-serif (This is font style of unedited webpage. Save this for awhile)  -->
    <div class="flex justify-between px-4 my-4">
        <div class="flex items-center gap-2">
            <!-- Back button -->
            <a href="../admin/student-record.php" aria-label="Go back" id="goBackButton">
                <img src="../assets/svg/back.svg" alt="Go back" class="w-6 h-6">
            </a>

            <!-- Header of the container -->
            <p>
                Student Files
            </p>
        </div>

        <!-- Buttons -->
        <div class="inline-flex gap-2">
            <!-- Edit button -->
            <!-- <button onClick="printStudentDetails();" class="p-2 border-2 border-blue-500 bg-white rounded-md text-xs text-black hover:bg-blue-700">
                Edit
            </button> -->
            <!-- Print button -->
            <button onClick="printDocument();" class="p-2 bg-blue-500 rounded-md text-xs font-medium text-black hover:text-white hover:bg-blue-700">
                Print
            </button>
        </div>
    </div>

    <div>
        <div class="tabs cursor-pointer inline-flex gap-2">
            <div id="tab-1" class="tab px-3.5 py-2 bg-blue-300 rounded-t-md text-black hover:text-white hover:bg-blue-700 text-xs" onclick="showContent(1)">
                <p>Transcript of Record</p>
            </div>
            <div id="tab-2" class="tab px-3.5 py-2 bg-blue-300 rounded-t-md text-black hover:text-white hover:bg-blue-700 text-xs" onclick="showContent(2)">Special Order</div>
            <div id="tab-3" class="tab px-3.5 py-2 bg-blue-300 rounded-t-md text-black hover:text-white hover:bg-blue-700 text-xs" onclick="showContent(3)">Good Moral Certificate</div>
            <div id="tab-4" class="tab px-3.5 py-2 bg-blue-300 rounded-t-md text-black hover:text-white hover:bg-blue-700 text-xs" onclick="showContent(4)">Certificate of Honorable Dismissal</div>
        </div>

        <div id="content-section-1" class="content-section  w-full bg-white border border-blue-100 gap-2 font-semibold printable-area">
            <?php if (isset($student_details)) : ?>
                <main class="px-1.5 pt-12 tor-template">
                    <!-- Start of TOR header -->
                    <header>
                        <div class="flex justify-center items-center">
                            <img src="../assets/svg/TOR_logo.png" class="h-20 w-20 mr-3" style="margin-top: -50px;">

                            <div class="text-center">
                                <p class="text-4xl font-bold tracking-wide">OUR LADY OF LOURDES COLLEGE</p>
                                <p class="text-base font-normal mt-1">5031 Gen. T De Leon Valenzuela City</p>
                                <p class="text-base font-normal">ollc.edu.ph <span class="px-2">|</span> 922-00-70</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div>
                                <h1 class="text-xl font-semibold uppercase text-center mt-8">Office of the Registrar</h1>
                                <h2 class="text-2xl font-semibold uppercase text-center ">Official Transcript of Records</h2>
                            </div>

                            <div class="absolute right-0 bottom-px">
                                <?php if (empty($student_details['profile_picture'])) : ?>
                                    <img src="../assets/svg/profile.svg" class="w-32 h-32" alt="">
                                <?php else : ?>
                                    <?php
                                    $profilePicturePath = htmlspecialchars($student_details['profile_picture']);
                                    $profilePicturePath = str_replace("../student/", "", $profilePicturePath);
                                    $fullImagePath = "../student/" . $profilePicturePath;
                                    ?>
                                    <img src="<?= $fullImagePath ?>" class="w-28 h-28" alt="">
                                <?php endif; ?>
                            </div>
                        </div>
                    </header>
                    <!-- End of TOR header -->

                    <!-- Start of Personal Data -->
                    <section class="font-normal border-r-2 border-t-2 border-l-2 border-black text-xs">
                        <div class="border-b border-black">
                            <p class="pl-2">NAME:
                                <span class="font-bold ml-3 uppercase">
                                    <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= substr($student_details['middle_name'], 0, 1) ?>. <?= $student_details['suffix'] ?>
                                </span>
                            </p>
                        </div>

                        <div class="border-b border-black">
                            <p class="text-center font-bold">PERSONAL DATA</p>
                        </div>

                        <div class="border-b border-black grid grid-cols-4">
                            <div class="col-span-2 pl-2">
                                <p>Sex <span style="margin: 0 8px 0 89px;">:</span>
                                    <?php
                                    $originalGender = $student_details['gender'];
                                    $formattedGender = ucwords($originalGender);
                                    echo $formattedGender;
                                    ?>
                                </p>
                                <p>Date of Birth <span style="margin: 0 8px 0 40px;">:</span>
                                    <?php
                                    $originalDate = $student_details['birthday'];
                                    $dateTime = new DateTime($originalDate);
                                    $formattedDate = $dateTime->format('F j, Y');
                                    echo $formattedDate;
                                    ?>
                                </p>
                                <p>Place of Birth <span style="margin: 0 8px 0 38px;">:</span>
                                    <span><?= $student_details['birth_place'] ?></span>
                                </p>
                            </div>

                            <div class="col-span-2 pl-10">
                                <p>Nationality <span style="padding: 0 8px 0 62px;">:</span>
                                    <span><?= $student_details['citizenship'] ?></span>
                                </p>
                                <p>Date of Admission <span style="padding: 0 8px 0 23px;">:</span>
                                    <span class="date-tor px-1" role="textbox" contenteditable></span>
                                </p>
                                <p>Admission Credential <span class="mx-2">:</span>
                                    <span>F-137</span>
                                </p>
                            </div>

                            <div class="col-span-4 pl-2">
                                <p>Address <span style="margin: 0 8px 0 65px;">:</span>
                                    <span><?= $student_details['address'] ?> <?= $student_details['city'] ?></span>
                                </p>
                            </div>
                        </div>

                        <div class="border-b border-black">
                            <p class="text-center font-bold">SCHOLASTIC DATA</p>
                        </div>

                        <div class="border-b border-black grid grid-cols-4">
                            <div class="col-span-2 pl-2">
                                <p class="font-bold">PRELIMINARY EDUCATION</p>
                                <p>Elementary <span style="margin: 0 8px 0 50px;">:</span>
                                    <span><?= $student_details['elementary_name'] ?></span>
                                </p>
                                <p>Junior High School <span style="margin: 0 9px;">:</span>
                                    <span> <?= $student_details['junior_high_name'] ?></span>
                                </p>
                                <p>Senior High School <span class="mx-2">:</span>
                                    <span><?= $student_details['senior_high_name'] ?></span>
                                </p>
                            </div>

                            <div class="col-span-2 pl-10">
                                <p>Course <span class="mx-2">:</span>
                                    <span><?= $student_details['course_name'] ?></span>
                                </p>
                                <p>Major <span class="ml-3.5 mr-2">:</span>
                                    <span><?php
                                            $course = $student_details['course_name'];
                                            $major = '';

                                            switch ($course) {
                                                case 'Bachelor of Science in Information Technology':
                                                case 'Bachelor of Science in Criminology':
                                                case 'Bachelor of Elementary Education':
                                                    $major = 'N/A';
                                                    break;

                                                case 'Bachelor of Science in Business Administration':
                                                    $major = 'Operations Management';
                                                    break;

                                                case 'Bachelor of Education Major in English':
                                                    $major = 'English';
                                                    break;

                                                case 'Bachelor of Education Major in Math':
                                                    $major = 'Mathematics';
                                                    break;

                                                default:
                                                    $major = 'Unknown';
                                            }
                                            echo $major;
                                            ?></span>
                                </p>

                                <div class="flex items-center">
                                    <p>Date of Graduation <span class="mx-2">:</span></p>
                                    <span class="date-tor px-1" role="textbox" contenteditable></span>
                                </div>

                                <div class="flex items-center">
                                    <p>Special Order No. <span class="ml-4 mr-2">:</span></p>
                                    <span class="SO_number uppercase ml-1 px-1" role="textbox" contenteditable></span>
                                </div>
                            </div>
                        </div>

                        <div id="blank-space" class="w-full h-4 border-b border-black"></div>
                    </section>
                    <!-- End of Personal Data -->

                    <section class="font-normal border-r-2 border-l-2 border-b border-black text-xs">
                        <table class="w-full ">
                            <thead>
                                <tr class="font-bold">
                                    <td rowspan="2" class="text-center w-24 border-r border-b border-black">COURSE CODE</td>
                                    <td rowspan="2" class="text-center border-r  border-b border-black">COURSE TITLE</td>
                                    <td colspan="2" class="text-center border-r border-b border-black">GRADES</td>
                                    <td rowspan="2" class="text-center w-14 border-b border-black">UNITS</td>
                                </tr>

                                <tr class="font-bold">
                                    <td class="text-center w-14 border-r border-b border-black">FINAL</td>
                                    <td class="text-center w-16 border-r border-b border-black">RE-EXAM</td>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- First Year -->
                                <div>
                                <?php
                                    // Include the database connection file
                                    include '../php/conn.php';

                                    // Escape the student_id from the GET parameters
                                    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

                                    $enrolledSubjectsQuery = "SELECT 
                                                                    yl.year_level, 
                                                                    stbl.semester, 
                                                                    sbj.code, 
                                                                    sbj.name, 
                                                                    sbj.unit,
                                                                    enrolled_subjects.prelim,
                                                                    enrolled_subjects.midterm,
                                                                    enrolled_subjects.finals,
                                                                    ROUND((enrolled_subjects.prelim + enrolled_subjects.midterm + enrolled_subjects.finals) / 3, 2) as total
                                                                FROM 
                                                                    students
                                                                    JOIN enrolled_subjects ON students.student_id = enrolled_subjects.student_id
                                                                    JOIN subjects sbj ON enrolled_subjects.subject_id = sbj.subject_id
                                                                    JOIN student_number ON students.student_number_id = student_number.student_number_id
                                                                    JOIN year_level yl ON enrolled_subjects.year_level_id = yl.year_level_id
                                                                    JOIN semester_tbl stbl ON enrolled_subjects.semester_tbl_id = stbl.semester_tbl_id
                                                                WHERE student_number.student_number = ?
                                                                AND yl.year_level = 'First Year'
                                                                AND stbl.semester = 'First Semester'";
                                    

                                    // Prepare the statement
                                    $stmt = mysqli_prepare($conn, $enrolledSubjectsQuery);

                                    // Check for errors during preparation
                                    if (!$stmt) {
                                        die("Error during statement preparation: " . mysqli_error($conn));
                                    }

                                    // Bind the parameter
                                    mysqli_stmt_bind_param($stmt, "s", $student_id);

                                    // Execute the query
                                    mysqli_stmt_execute($stmt);

                                    // Check for errors during execution
                                    if (mysqli_stmt_errno($stmt)) {
                                        die("Error during statement execution: " . mysqli_stmt_error($stmt));
                                    }

                                    // Bind the result variables
                                    mysqli_stmt_bind_result($stmt, $year_level, $semester, $code, $name, $unit, $prelim, $midterm, $finals, $total);

                                    // Display the results
                                    echo '<div>';

                                    while (mysqli_stmt_fetch($stmt)) {
                                        // Display the header for the semester
                                        echo "<tr id='blank-space-for-spacing'>
                                                <td class='border-r border-black h-2'></td>
                                                <td class='border-r border-black h-2'></td>
                                                <td class='border-r border-black h-2'></td>
                                                <td class='border-r border-black h-2'></td>
                                            </tr>";

                                        echo "<tr>
                                                <td class='border-r border-black'></td>
                                                <td class='font-bold border-r border-black pl-3'>$semester SY $year_level</td>
                                                <td class='border-r border-black'></td>
                                                <td class='border-r border-black'></td>
                                            </tr>";

                                        // Display the enrolled subjects
                                        echo "<tr>
                                                <td class='pl-3 border-r border-black'>$code</td>
                                                <td class='pl-5 border-r border-black'>$name</td>
                                                <td class='text-center border-r border-black'>$total</td>
                                                <td class='text-center border-r border-black'></td>
                                                <td class='text-center'>$unit</td>
                                            </tr>";
                                    }

                                    echo '</div>';

                                    // Close the statement and connection
                                    mysqli_stmt_close($stmt);
                                    mysqli_close($conn);
                                    ?>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">Second Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                </div>

                                <!-- Second Year -->
                                <div>
                                    <!-- First Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">First Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>

                                    <!-- Second Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">Second Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                </div>

                                <!-- Third Year -->
                                <div>
                                    <!-- First Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">First Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>

                                    <!-- Second Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">Second Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                </div>

                                <!-- Fourth Year -->
                                <div>
                                    <!-- First Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">First Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>

                                    <!-- Second Semester -->
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr>
                                        <td class="border-r border-black"></td>
                                        <td class="font-bold border-r border-black pl-3">Second Semester SY [DATE] &ndash; [DATE]</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT1</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 1</td>
                                        <td class="text-center border-r border-black">1.75</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3 border-r border-black">SBJCT2</td>
                                        <td class="pl-5 border-r border-black">Sample Subject 2</td>
                                        <td class="text-center border-r border-black">1.50</td>
                                        <td class="text-center border-r border-black"></td>
                                        <td class="text-center">3</td>
                                    </tr>
                                </div>

                                <!-- Closing Remerks of Grades -->
                                <div>
                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>

                                    <tr id="closing-remarks">
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black text-center">*********TRANSCRIPT CLOSED*********</td>
                                        <td class="border-r border-black"></td>
                                        <td class="border-r border-black"></td>
                                    </tr>

                                    <tr id="blank-space-for-spacing">
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                        <td class="border-r border-black h-2"></td>
                                    </tr>
                                </div>
                            </tbody>
                        </table>
                    </section>

                    <footer class="font-normal mb-5 border-r-2 border-l-2 border-b-2 border-black text-xs">
                        <div id="blank-space" class="w-full h-4 border-b border-black"></div>

                        <div class="flex pl-8 border-b border-black h-10 py-3">
                            <p><span class="font-bold">REMARKS :</span> <span class="pl-7">COPY FOR:</span></p>
                            <span class="remarks uppercase ml-1 px-1" role="textbox" contenteditable></span>
                        </div>

                        <div id="blank-space" class="w-full h-4 border-b border-black"></div>

                        <!-- Grading System -->
                        <div class="pl-2" style="font-size: 10px;">
                            <p>Grading System:</p>
                            <div class="grid grid-cols-9">
                                <p><span>1.00</span><span class="pl-2">97 &ndash; 100%</span></p>
                                <p><span>1.50</span><span class="pl-2">92 &ndash; 96%</span></p>
                                <p><span>2.00</span><span class="pl-2">87 &ndash; 89%</span></p>
                                <p><span>2.50</span><span class="pl-2">80 &ndash; 83%</span></p>
                                <p><span>3.00</span><span class="pl-2">75 &ndash; 77%</span></p>
                                <p><span>P</span><span class="pl-2">Pass</span></p>
                                <p><span>INC</span><span class="pl-2">Incomplete</span></p>
                                <p class="col-span-2">
                                    <span>UW</span><span class="pl-2">Unauthorized Withdrawal</span>
                                </p>
                                <p><span>1.25</span><span class="pl-2">94 &ndash; 96%</span></p>
                                <p><span>1.75</span><span class="pl-2">90 &ndash; 91%</span></p>
                                <p><span>2.25</span><span class="pl-2">84 &ndash; 86%</span></p>
                                <p><span>2.70</span><span class="pl-2">78 &ndash; 79%</span></p>
                                <p><span>5.00</span><span class="pl-2">Failure</span></p>
                                <p><span>N</span><span class="pl-2">No Credit</span></p>
                                <p class="col-span-2">
                                    <span>AW</span><span class="pl-2">Authorized Withdrawal</span>
                                </p>
                            </div>

                            <!-- Credits -->
                            <div>
                                <p>
                                    Credits:
                                    <span class="pl-3">One unit of credit is equivalent to one hour of class activity
                                        each week for a period of complete semester
                                    </span>
                                </p>
                            </div>

                            <!-- Note -->
                            <div class="mb-5">
                                <p>Note</p>
                                <p>
                                    This document is an original copy and is Valid when it bears the
                                    seal of the college / university
                                </p>
                                <p>
                                    Any erasure or alteration made in this copy renders the whole
                                    transcript invalid
                                </p>
                            </div>

                            <!-- Closing/Signature -->
                            <div class="flex justify-end mr-24">
                                <div class="text-center">
                                    <div class="w-38 border-black border-b">
                                        <p class="text-sm font-bold">
                                            Maria Grecilia Decilio
                                        </p>
                                    </div>

                                    <p class="text-xs mb-3 print:text-[8pt]">Registar</p>

                                    <p class="text-xs mb-3">
                                        Prepared & Checked by: R. R. Peralta
                                    </p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </main>
            <?php else : ?>
                <p>No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>

        <!-- Start of Special Order -->
        <div id="content-section-2" class="content-section w-full bg-white p-4 border border-blue-100 gap-2 font-semibold printable-area">
            <?php if (isset($student_details)) : ?>
                <main class="px-3 py-12 so-template">
                    <!-- Start of SO header -->
                    <header>
                        <div class="flex justify-center items-center">
                            <img src="../assets/svg/SO_logo.png" class="h-24 w-24">

                            <div class="text-center">
                                <p class="text-4xl font-bold tracking-wide">OUR LADY OF LOURDES COLLEGE</p>
                                <p class="text-xl font-normal mt-1">5031 Gen. T De Leon Valenzuela City</p>
                            </div>
                        </div>

                        <h1 class="text-2xl font-normal uppercase text-center tracking-wide my-8">Record of Candidate for Graduation</h1>
                    </header>
                    <!-- End of SO header -->

                    <!-- Start of Students Data -->
                    <section class="font-normal mb-5">
                        <!-- Personal Infromation -->
                        <div>
                            <div class="grid grid-cols-3">
                                <p class="col-span-2 leading-7">Name :
                                    <span class="font-bold uppercase" style="padding-left: 102px; font-size: 18px;">
                                        <?= $student_details['surname'] ?> <?= $student_details['first_name'] ?> <?= substr($student_details['middle_name'], 0, 1) ?>. <?= $student_details['suffix'] ?>
                                    </span>
                                </p>

                                <p class="leading-7 pl-8">Sex :
                                    <span class="pl-14">
                                        <?php
                                        $originalGender = $student_details['gender'];
                                        $formattedGender = ucwords($originalGender);
                                        echo $formattedGender;
                                        ?>
                                    </span>
                                </p>

                                <p class="col-span-2 leading-7">Birthdate :
                                    <span style="padding-left: 81px;">
                                        <?php
                                        $originalDate = $student_details['birthday'];
                                        $dateTime = new DateTime($originalDate);
                                        $formattedDate = $dateTime->format('F j, Y');
                                        echo $formattedDate;
                                        ?>
                                    </span>
                                </p>

                                <p class="leading-7 pl-7">Birthplace :
                                    <span class="pl-3.5">
                                        <?= $student_details['birth_place'] ?>
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="leading-7">Entrance Data : <span class="pl-12">F-137</span></p>
                                <p class="leading-7">College of:
                                    <span style="padding-left: 78px;">
                                        <?php
                                        $course = $student_details['course_name'];
                                        $abbreviation = '';
                                        switch ($course) {
                                            case 'Bachelor of Science in Business Administration':
                                                $abbreviation = 'BSBA';
                                                break;
                                            case 'Bachelor of Science in Information Technology':
                                                $abbreviation = 'BSIT';
                                                break;
                                            case 'Bachelor of Elementary Education':
                                                $abbreviation = 'BEEd';
                                                break;
                                            case 'Bachelor of Education Major in Math':
                                            case 'Bachelor of Education Major in English':
                                                $abbreviation = 'BSEd';
                                                break;
                                            case 'Bachelor of Science in Hospitality Management':
                                                $abbreviation = 'BSHM';
                                                break;
                                            case 'Bachelor of Science in Criminology':
                                                $abbreviation = 'BSCRIM';
                                                break;

                                            default:
                                                $abbreviation = 'Unknown';
                                        }
                                        echo $abbreviation;
                                        ?>

                                    </span>
                                </p>
                                <p class="leading-7 ">Candidate for Title :
                                    <span class="pl-3.5"><?= $student_details['course_name'] ?></span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 mb-5">
                            <p class="col-span-2 leading-7">Major :
                                <span style="padding-left: 105px;">
                                    <?php
                                    $course = $student_details['course_name'];
                                    $major = '';

                                    switch ($course) {
                                        case 'Bachelor of Science in Information Technology':
                                        case 'Bachelor of Science in Criminology':
                                        case 'Bachelor of Elementary Education':
                                            $major = 'N/A';
                                            break;

                                        case 'Bachelor of Science in Business Administration':
                                            $major = 'Operations Management';
                                            break;

                                        case 'Bachelor of Education Major in English':
                                            $major = 'English';
                                            break;

                                        case 'Bachelor of Education Major in Math':
                                            $major = 'Mathematics';
                                            break;

                                        default:
                                            $major = 'Unknown';
                                    }
                                    echo $major;
                                    ?>
                                </span>
                            </p>

                            <p class="leading-7 pl-7">Minor : <span class="pl-12">N/A</span></p>

                            <p class="col-span-3 leading-7">Date of Graduation : <span class="date px-1 ml-2" role="textbox" contenteditable></p>
                        </div>

                        <!-- Scholastic Data -->
                        <div class="">
                            <p class="mb-4">PRELIMINARY EDUCATION</p>

                            <div class="grid grid-cols-5 mb-5">
                                <div>
                                    <p class="mb-3">Completed</p>
                                    <p class="mb-1.5">Elementary School:</p>
                                    <p class="mb-1.5">Junior High School:</p>
                                    <p class="mb-1.5">Senior High School:</p>
                                </div>

                                <div class="col-span-3 text-center">
                                    <p class="mb-3">Name of School</p>
                                    <p class="mb-1.5"> <?= $student_details['elementary_name'] ?></p>
                                    <p class="mb-1.5"> <?= $student_details['junior_high_name'] ?></p>
                                    <p class="mb-1.5"> <?= $student_details['senior_high_name'] ?></p>
                                </div>

                                <div class="text-center">
                                    <p class="mb-3">Year</p>
                                    <p class="mb-1.5"> <?= $student_details['elementary_year'] ?></p>
                                    <p class="mb-1.5"><?= $student_details['junior_high_year'] ?></p>
                                    <p class="mb-1.5"><?= $student_details['senior_high_year'] ?></p>
                                </div>
                            </div>

                            <div>
                                <table class="w-full" style="font-size: 11.5px;">

                                    <tr class="border border-black">
                                        <td scope="col" class="border-r border-black text-center">Subjects</td>
                                        <td scope="col" class="border-r border-black text-center" style="width: 50px;">Final Grade</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">1</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">2</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">3</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">4</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">5</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">6</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">7</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">8</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">9</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">10</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">11</td>
                                        <td scope="col" class="border-r border-black w-7 text-center">12</td>
                                        <td scope="col" class="border-r border-black text-center w-14">Re-exam</td>
                                        <td scope="col" class="w-10 text-center">Units</td>
                                    </tr>


                                    <tbody>
                                        <!-- Start of First Year -->
                                        <!-- First Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">First Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>

                                        <!-- Second Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">Second Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>
                                        <!-- End of First Year -->

                                        <!-- Start of Second Year -->
                                        <!-- First Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">First Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>

                                        <!-- Second Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">Second Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>
                                        <!-- End of Second Year -->

                                        <!-- Start of Third Year -->
                                        <!-- First Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">First Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>

                                        <!-- Second Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">Second Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>
                                        <!-- End of Third Year -->

                                        <!-- Start of Fourth Year -->
                                        <!-- First Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">First Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>

                                        <!-- Second Semester -->
                                        <div>
                                            <tr class="border border-black">
                                                <td colspan="16" class="pl-3 font-semibold">Second Semester SY [Year Start] - [Year End]</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 1</td>
                                                <td class="border border-black text-center">1.00</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 2</td>
                                                <td class="border border-black text-center">1.75</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 border-l  border-black">Sample Subject 3</td>
                                                <td class="border border-black text-center">1.50</td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center"></td>
                                                <td class="border border-black text-center">3</td>
                                            </tr>
                                        </div>
                                        <!-- End of Fourth Year -->

                                        <tr class="border border-black">
                                            <td class="pl-3 border-r border-black font-semibold" colspan="15">CREDITS PRESENTED FOR GRADUATION </td>
                                            <td class="text-center">150</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <!-- End of Students Data -->

                    <!-- Start of Legend -->
                    <section class="text-sm mb-14">
                        <p class="text-center uppercase font-semibold mb-4">Legend</p>

                        <div class="grid grid-cols-3 px-24 font-normal">
                            <div>
                                <p>1. Language</p>
                                <p>2. Social Science</p>
                                <p>3. Logic</p>
                                <p>4. Rizal Course</p>
                            </div>

                            <div>
                                <p>5. Natural Science</p>
                                <p>6. Law</p>
                                <p>7. Taxation</p>
                                <p>8. Mathematics</p>
                            </div>

                            <div>
                                <p>9. Core</p>
                                <p>10. Business</p>
                                <p>11. Physical Education</p>
                                <p>8. Military Science</p>
                            </div>
                        </div>
                    </section>
                    <!-- End of Legend -->

                    <!-- Start of Certification -->
                    <section class="font-normal mb-20">
                        <p class="text-center font-semibold mb-5  uppercase">Certification</p>

                        <p class="text-justify leading-loose" style="text-indent: 80px;">
                            I hereby certify that the foregoing records of
                            <span class="uppercase font-semibold" style="font-size: 18px;">
                                <?= $student_details['first_name'] ?> <?= substr($student_details['middle_name'], 0, 1) ?>. <?= $student_details['surname'] ?> <?= $student_details['suffix'] ?>
                            </span>
                            candidate for garduation have been verified by me that the true
                            copies substantiating the same are kept in the files of our
                            College.
                        </p>
                    </section>
                    <!-- End of Certification -->

                    <footer class="font-normal">
                        <div class="flex flex-col justify-center items-center">
                            <p class="font-semibold text-center">MARIA GRECILIA C. DECILIO</p>
                            <div class="border-t border-black w-56 text-center">
                                <p>Registar</p>
                            </div>

                        </div>
                    </footer>


                </main>
            <?php else : ?>
                <p>No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>
        <!-- End of Special Order -->

        <!-- Start of Good Moral Certificate -->
        <div id="content-section-3" class="content-section w-full bg-white p-4 border border-blue-100 gap-2 font-semibold printable-area">
            <?php if (isset($student_details)) : ?>
                <main class="px-6 py-12 certificate-gm">
                    <!-- Start of certificate header -->
                    <header>
                        <img src="../assets/svg/ollclogo.svg" class="h-20 mx-auto">
                        <h1 class="text-4xl font-bold uppercase text-center tracking-widest mt-16 mb-20">C e r t i f i c a t i o n</h1>
                    </header>
                    <!-- End of certificate header -->

                    <!-- Start of certificate body  -->
                    <section class="font-normal certificate-body leading-8">
                        <div class="mb-20">
                            <p class="uppercase mb-12">To whom it may concern:</p>

                            <p class="text-justify mb-5 letter">
                                This is to certify that
                                <span class="text-2xl uppercase font-semibold underline">
                                    <?= $student_details['first_name'] ?> <?= substr($student_details['middle_name'], 0, 1) ?>. <?= $student_details['surname'] ?> <?= $student_details['suffix'] ?>
                                </span>
                                is a bonafide College student of this school for
                                <span class="num-of-sem-attended px-1" role="textbox" contenteditable></span> semesters
                                in
                                <span class="uppercase font-semibold">
                                    <?= $student_details['course_name'] ?>
                                </span>
                                <span class="sem-attended px-1" role="textbox" contenteditable></span> Semester of
                                School Year <span class="syStart px-1" role="textbox" contenteditable></span> &ndash; <span class="syEnd px-1" role="textbox" contenteditable></span>.
                            </p>

                            <p class="text-justify mb-5 letter">Our records show that he has not been subjected to any disciplinary action during his stay in school and he has a good moral character.</p>

                            <p class="text-justify mb-5 letter">This certification is issued upon request by the above-named student for <span class="purpose uppercase px-1" role="textbox" contenteditable></span>.</p>

                            <p class="text-justify mb-5 letter">Valenzuela City,<span class="date px-1" role="textbox" contenteditable></span>.</p>.</p>
                        </div>

                        <div class="flex justify-end mb-32">
                            <div class="text-center">
                                <p class="uppercase text-lg font-semibold">Maria Grecilia C. Decilio</p>
                                <p class="text-sm">Registrar</p>
                            </div>
                        </div>
                    </section>

                    <footer class="font-normal text-sm">
                        <p class="mb-1">Not valid without the dry seal</p>

                        <hr class="mb-2 border-1 border-black">

                        <div>
                            <div class="flex justify-between mb-1">
                                <p>Our Lady of Lourdes College</p>
                                <p>Tel. No. 922-00-77/922-00-70</p>
                            </div>

                            <div class="flex justify-between">
                                <p>5031 Gen. T. de Leon, Valenzuela City</p>
                                <p>www.ollc.edu.ph</p>
                            </div>
                        </div>
                    </footer>
                    <!-- End of certificate body  -->
                </main>

            <?php else : ?>
                <p>No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>
        <!-- End of Good Moral Certifcate -->

        <!-- Start of Certificate of Honorable Dismissal -->
        <div id="content-section-4" class="content-section w-full bg-white p-4 border border-blue-100 gap-2 printable-area">
            <?php if (isset($student_details)) : ?>
                <main class="px-6 py-12 certificate-hd">
                    <!-- Start of certificate header -->
                    <header>
                        <img src="../assets/svg/ollclogo.svg" class="h-20 mx-auto">
                        <h1 class="text-3xl font-bold uppercase text-center tracking-widest mt-16 mb-20">CERTIFICATE OF HONORABLE DISMISSAL</h1>
                    </header>
                    <!-- End of certificate header -->

                    <!-- Start of certificate body  -->
                    <section class="font-normal leading-7">
                        <div class="mb-20">
                            <p class="uppercase mb-12">To whom it may concern:</p>

                            <p class="text-justify mb-5 letter">
                                This is to certify that
                                <span class="text-2xl uppercase font-semibold underline student-name">
                                    <?= $student_details['first_name'] ?> <?= substr($student_details['middle_name'], 0, 1) ?>. <?= $student_details['surname'] ?> <?= $student_details['suffix'] ?>
                                </span>
                                has been a student of this institution for
                                <span class="num-of-sem-attended px-1" role="textbox" contenteditable></span> semester/s
                                in
                                <span class="uppercase font-semibold">
                                    <?= $student_details['course_name'] ?>
                                </span> during the
                                <span class="sem-attended px-1" role="textbox" contenteditable></span> Semester
                                School Year <span class="syStart px-1" role="textbox" contenteditable></span> &ndash; <span class="syEnd px-1" role="textbox" contenteditable></span>..
                            </p>

                            <p class="text-justify mb-5 letter">He is granted Honorable dismissal effective today, <span class="effective-date px-1" role="textbox" contenteditable></span>.</p>
                        </div>

                        <div class="flex justify-end mb-14">
                            <div class="text-center">
                                <p class="uppercase text-lg font-semibold">Maria Grecilia C. Decilio</p>
                                <p class="text-sm">Registrar</p>
                            </div>
                        </div>
                    </section>
                    <!-- End of certificate body  -->

                    <!-- Start of certificate return slip  -->
                    <section class="font-normal border-black border-t border-dashed">
                        <div class="slip-header">
                            <p class="text-center mt-3">Return Slip</p>
                        </div>

                        <div class="my-5">
                            <p>The Registrar</p>
                            <p>Our Lady of Lourdes College</p>
                            <p>5031 Gen. T de Leon Valenzuela City</p>
                        </div>

                        <div class="mb-14">
                            <p class="mb-4">Sir / Madam</p>

                            <p class="text-justify mb-5 letter">
                                I have the honor to request for the Official Transcript of Records of ___________________________________________ .
                                Who has been temporarily enrolled in our school pending receipt of his/ her Official Transcript of Records.
                            </p>

                            <p>Name of School: _____________________________________________________</p>
                            <p>Address: _____________________________________________________________</p>
                        </div>

                        <div class="flex justify-end mb-14">
                            <div class="w-52 border-black border-t pt-1 text-center">
                                <p>Registar</p>
                            </div>
                        </div>

                        <div class="flex justify-start mb-14">
                            <div class="w-52 border-black border-t pt-1 text-center">
                                <p>Student's Signature</p>
                            </div>
                        </div>


                        <p>Not valid without the dry seal</p>

                    </section>
                    <!-- End of certificate return slip  -->
                </main>
            <?php else : ?>
                <p>No student details found for the specified ID.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- End of Certificate of Honorable Dismissal -->

</body>

</html>
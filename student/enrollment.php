<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../../login.php");
    exit();
}

include '../php/conn.php';

$studentNumber = $_SESSION['student_number'];

// Fetch student information
$sqlStudent = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, ed.course, ci.city, ci.mobile_number, ci.email
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
        WHERE sn.student_number = ?";

$stmtStudent = $conn->prepare($sqlStudent);

if (!$stmtStudent) {
    die("Error in SQL query: " . $conn->error);
}

$stmtStudent->bind_param("s", $studentNumber);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();

if ($resultStudent === false) {
    die("Error in query execution: " . $stmtStudent->error);
}

if ($resultStudent->num_rows == 1) {
    $rowStudent = $resultStudent->fetch_assoc();

    $firstName = $rowStudent['first_name'];
    $surname = $rowStudent['surname'];
    $middleName = $rowStudent['middle_name'] ?? '';
    $status = $rowStudent['status'];
    $course = $rowStudent['course'];
    $city = $rowStudent['city'];
    $mobile_number = $rowStudent['mobile_number'];
    $email = $rowStudent['email'];
    $suffix = $rowStudent['suffix'];

    $stmtStudent->close();
} else {
    header("Location: ../../login.php");
    exit();
}

// Fetch subjects
$sqlSubjects = "SELECT * FROM subject";

$stmtSubjects = $conn->prepare($sqlSubjects);

if (!$stmtSubjects) {
    die("Error in SQL query: " . $conn->error);
}

$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();

if ($resultSubjects === false) {
    die("Error in query execution: " . $stmtSubjects->error);
}

$subjects = [];

while ($rowSubjects = $resultSubjects->fetch_assoc()) {
    $subjects[] = $rowSubjects;
}

$stmtSubjects->close();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if selected subjects are submitted
    if (isset($_POST['selectedSubjects']) && is_array($_POST['selectedSubjects'])) {
        $selectedSubjects = $_POST['selectedSubjects'];

        // Insert selected subjects into the database
        $sqlInsertSubjects = "INSERT INTO enrolled_subjects (student_number, subject_id) VALUES (?, ?)";
        $stmtInsertSubjects = $conn->prepare($sqlInsertSubjects);

        foreach ($selectedSubjects as $subjectId) {
            $stmtInsertSubjects->bind_param("si", $studentNumber, $subjectId);
            $stmtInsertSubjects->execute();
        }

        $stmtInsertSubjects->close();
    }

    // ... your existing code for other form processing ...
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="icon" type="image/x-icon" href="../assets/svg/ollcLogoNoName.svg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/svg/ollcLogoNoName.svg" type="image/x-icon">
</head>

<body>
    <div class="font-[roboto-serif]">
        <div>
            <?php include './topbar.php'; ?>
        </div>
        <div class="w-full"><img src="../assets/img/admission-banner.png" class="w-full" alt=""></div>
        <form action="../php/pre-registration.php" method="post" onsubmit="return submitForm()">
            <div class="w-full flex justify-center items-center ">
                <div class="w-1/2 p-4 border border-blue-800 border-opacity-20 p-2 my-4 rounded-md drop-shadow-md">
                    <div class="font-bold text-2xl mb-4">
                        Enrollment
                    </div>
                    <div class="text-base">
                        We warmly welcome senior high school graduates, college transferees, second coursers, and foreign applicants to our campus.
                        Kindly choose-out the enrollement form for a fast and efficient admissions procedure.
                    </div><br>
                    <div class="text-base">
                        By submitting this etc etc
                    </div>
                    <div class="text-base">
                        uhaw uhaw
                    </div>
                    <div class="mt-4 w-full">
                        <div class="flex justify-start items-center w-full gap-2">
                            <div class="font-bold text-lg w-auto">
                                You are applying for:
                            </div>
                            <div class="w-1/2">
                                <div><select name="course" class="text-sm p-1 border border-blue-200 rounded-md">
                                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                                        <option value="BSED">Bachelor of Education Major in Math</option>
                                        <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                                        <option value="BSBA">Bachelor of Science in Business Administration</option>
                                    </select></div>
                            </div>
                        </div><br>
                        <div class="flex justify-start items-center w-full gap-2">
                            <div class="font-bold text-lg w-auto">
                                Please select your semester:
                            </div>
                            <div class="w-1/2">
                                <div><select name="semester" class="text-sm p-1 border border-blue-200 rounded-md">
                                        <option value="1st">First Semester</option>
                                        <option value="2nd">Second Semester</option>
                                    </select></div>
                            </div>
                        </div><br>
                        <div class="flex justify-start items-center w-full gap-2">
                            <div class="font-bold text-lg w-auto">
                                Please select your Year Level:
                            </div>
                            <div class="w-1/2">
                                <div><select name="year" class="text-sm p-1 border border-blue-200 rounded-md">
                                        <option value="Year 1">Year 1</option>
                                        <option value="Year 2">Year 2</option>
                                        <option value="Year 3">Year 3</option>
                                        <option value="Year 4">Year 4</option>
                                    </select></div>
                            </div>
                        </div><br>
                    </div>
                    <div class="w-full flex justify-center items-center ">
                        <button type="submit" name="submit" value="Submit" class="bg-blue-400 mt-2 py-2 px-8 shadow inline-flex gap-2 text-white rounded-full hover:bg-blue-600 hover:font-semibold">Submit</button>
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                        // Check if selectedSubjects is set in the POST data
                        if (isset($_POST['selectedSubjects']) && is_array($_POST['selectedSubjects'])) {
                            $selectedSubjects = $_POST['selectedSubjects'];

                            // Now you can use $selectedSubjects to insert data into your database
                            // Insert code goes here...
                        } else {
                            // No subjects selected
                            echo "Please select at least one subject.";
                        }
                    }
                    ?>
                    <div class="mt-4">
                        <div class="inline-flex justify-start items-center gap-2 mt-2">
                            <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                            <div class="font-bold text-xl">Personal Information</div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center gap-2 w-full">
                                <div class="w-full">
                                    <div>Surname</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input type="text" id="stdSurname" name="stdSurname" autocomplete="family-name" required style="text-transform: capitalize;" class="w-full px-1"></div>
                                </div>
                                <div class="w-full">
                                    <div>First Name</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input type="text" id="stdFirstname" name="stdFirstname" autocomplete="given-name" required style="text-transform: capitalize;" class="w-full px-1"></div>
                                </div>
                                <div class="w-full">
                                    <div>Middle Name</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input type="text" id="stdMiddlename" name="stdMiddlename" required style="text-transform: capitalize;" class="w-full px-1"></div>
                                </div>
                                <div class="w-full">
                                    <div>Suffix</div>
                                    <div><select name="stdSuffix" id="suffixMenu" class="text-sm p-1 border border-blue-200 rounded-md w-full"></select></div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center gap-2 w-full">
                                <div class="w-full">
                                    <div>Semester</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input type="text" id="stdSurname" name="stdSurname" autocomplete="family-name" required style="text-transform: capitalize;" class="w-full px-1"></div>
                                </div>
                                <div class="w-full">
                                    <div>Year Level</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input type="text" id="stdSurname" name="stdSurname" autocomplete="family-name" required style="text-transform: capitalize;" class="w-full px-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="inline-flex justify-start items-center gap-2 mt-2">
                            <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                            <div class="font-bold text-xl">Student Information</div>
                        </div>
                        <!-- Display student information -->
                        <table class="border-collapse border border-slate-500 w-full mx-auto">
                            <thead>
                                <tr>
                                    <th class="border border-slate-500">Field</th>
                                    <th class="border border-slate-500">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-700">First Name</td>
                                    <td class="border border-slate-700"><?php echo $firstName; ?></td>
                                </tr>
                                <tr>
                                    <td class="border border-slate-700">Surname</td>
                                    <td class="border border-slate-700"><?php echo $surname; ?></td>
                                </tr>
                                <!-- Add more rows for other fields as needed -->
                            </tbody>
                        </table>
                    </div>
                   
                    <div class="mt-4">
                        <div class="inline-flex justify-start items-center gap-2 mt-2">
                            <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                            <div class="font-bold text-xl"> Please choose a Subjects</div>
                        </div>
                        <!-- Display subjects -->
                        <table class="border-collapse border border-slate-500 w-full mx-auto">
                            <thead>
                                <tr>
                                    <th class="border border-slate-500"></th>
                                    <th class="border border-slate-500">Subject Name</th>
                                    <th class="border border-slate-500">Subject Code</th>
                                    <th class="border border-slate-500">Subject Unit</th>
                                    <th class="border border-slate-500">Course</th>
                                    <th class="border border-slate-500">Semester</th>
                                    <th class="border border-slate-500">Year</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subjects as $subject) : ?>
                                    <tr class="text-center">
                                        <td class="border border-slate-700 w-6">
                                            <?php echo "Before Line 288";
                                            var_dump($selectedSubjects); ?>
                                            <input type="checkbox" name="selectedSubjects[]" value="<?php echo $subject['sub_id']; ?>">
                                            <?php echo "After Line 288"; ?>
                                        </td>
                                        <td class="border border-slate-700 "><?php echo $subject['sub_name']; ?></td>
                                        <td class="border border-slate-700 "><?php echo $subject['sub_code']; ?></td>
                                        <td class="border border-slate-700"><?php echo $subject['sub_unit']; ?></td>
                                        <td class="border border-slate-700 p-5"><?php echo $subject['course']; ?></td>
                                        <td class="border border-slate-700"><?php echo $subject['semester']; ?></td>
                                        <td class="border border-slate-700 "><?php echo $subject['year']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-full flex justify-center items-center ">
                        <button type="submit" name="submit" value="Submit" class="bg-blue-400 mt-2 py-2 px-8 shadow inline-flex gap-2 text-white rounded-full hover:bg-blue-600 hover:font-semibold">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div>
        <object data="./footer.html" type="text/html" width="100%" height="56px"></object>
    </div>

    <div id="popup" class="hidden h-screen w-screen fixed top-0 left-0">
        <div class="w-full h-full backdrop-filter backdrop-blur-sm flex justify-center items-center">
            <div class="p-5 bg-white border border-blue-200 rounded-md">
                <div class="grid gap-2 mb-2">
                    <div>
                        <b>Welcome to Our Lady of Lourdes College - Your Next Steps!</b>
                    </div>
                    <div>
                        Congratulations on completing the pre-registration process for Our Lady of Lourdes College!
                        <br>
                        We are thrilled to welcome you to our academic community.
                    </div>
                    <div>
                        To access your student account and complete your registration, follow these simple steps:
                    </div>
                    <div class=" grid gap-1">
                        <div class="font-semibold">1. Login Credentials:</div>
                        <div class="flex">
                            <div class="font-semibold">Student ID Number: &nbsp; </div>
                            <div id="studentNumber"></div>
                        </div>
                        <div class="flex">
                            <div class="font-semibold">Password: &nbsp; </div>
                            <div id="password"></div>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold">2. Login Instructions:</div>
                        <ul class="list-disc px-4">
                            <li>Visit our school website.</li>
                            <li>Click the "Student Portal" button in top navigation bar.</li>
                            <li>Enter your Student ID Number and Password.</li>
                            <li>Click "Login" to access your student account.</li>
                        </ul>
                    </div>
                    <div>
                        <div class="font-semibold">3. Complete Registration:</div>
                        <ul class="list-disc px-4">
                            <li>Once logged in, you'll find a form.</li>
                            <li>Fill in any missing information required for your official enrollment.</li>
                            <li>Review and confirm accuracy of the details you provided during pre-registration.</li>
                            <li>Upload any necessary documents as specified in the the registration process.</li>
                            <li>Submit the form.</li>
                        </ul>
                    </div>
                    <div>
                        <div class="font-semibold">4. Enrollment:</div>
                        <ul class="list-disc px-4">
                            <li>After completing the registration, you'll be directed to the enrollment section.</li>
                            <li>Follow the provided instructions to select your courses and finalize your enrollment <br> for the academic for the upcoming academic term</li>
                        </ul>
                    </div>
                    <div>
                        We're excited to have you as part of the Our Lady of Lourdes College family! Your journey towards academic success begins here. <br>
                        If you have any additional queries or require further assistance, do not hesitate to reach out.
                    </div>
                </div>
                <div class="w-full flex justify-center items-center">
                    <button class="bg-blue-400 mt-2 py-2 px-8 shadow inline-flex gap-2 text-white rounded-full hover:bg-blue-600 hover:font-semibold" onclick="goToLoginPage()">Proceed to Login</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/pre-registration-menu.js"></script>
    <script src="../assets/js/topbar.js"></script>
    <script src="../assets/js/pre-registration.js"></script>
</body>

</html>
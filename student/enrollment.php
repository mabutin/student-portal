<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../../login.php");
    exit();
}

include '../php/conn.php';

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, ed.course, ci.city, ci.mobile_number, ci.email
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
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
    $city = $row['city'];
    $mobile_number = $row['mobile_number'];
    $email = $row['email'];
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
                        We warmly welcome  senior high school graduates, college transferees, second coursers, and foreign applicants to our campus.
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
                                You applied for: 
                            </div>
                            <div class="w-3/4">
                                <div><select name="course" id="courseMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                            </div>
                        </div><br>
                        <div class="flex justify-start items-center w-full gap-2">
                            <div class="font-bold text-lg w-auto">
                                Please select your semester: 
                            </div>
                            <div class="w-3/4">
                                <div><select name="course" id="courseMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                            </div>
                        </div><br>
                        <div class="flex justify-start items-center w-full gap-2">
                            <div class="font-bold text-lg w-auto">
                                Please select your Year Level: 
                            </div>
                            <div class="w-3/4">
                                <div><select name="course" id="courseMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                            </div>
                        </div><br>
                    </div>
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
                            <div class="font-bold text-xl">Contact Information</div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center gap-2 w-full">
                                <div class="w-full">
                                    <div>City </div>
                                    <div><select name="stdCity" id="cityMenu" class="text-sm p-1 border border-blue-200 rounded-md w-full"></select></div>
                                </div>
                                <div class="w-full">
                                    <div>Email</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full flex justify-between items-center relative gap-2">
                                        <input type="text" name="email" id="email" class="w-full" autocomplete="email" onblur="validateEmail()">
                                        <p id="emailError" class="text-red-500 hidden absolute top-full left-0 bg-white p-2 border border-red-500 rounded-md w-full">
                                            Invalid email format. Example: example@gmail.com
                                        </p>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div>Cellphone</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex w-full"><span class="border-r border-blue-200 pr-2">+63</span><span class="w-full"><input type="text" name="stdMobile" id="stdMobile" class="w-full px-1" required></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="inline-flex justify-start items-center gap-2 mt-2">
                            <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                            <div class="font-bold text-xl">Choose Subjects to enroll</div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center gap-2 w-full">
                                <div class="w-full">
                                    <div>City </div>
                                    <div><select name="stdCity" id="cityMenu" class="text-sm p-1 border border-blue-200 rounded-md w-full"></select></div>
                                </div>
                                <div class="w-full">
                                    <div>Email</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full flex justify-between items-center relative gap-2">
                                        <input type="text" name="email" id="email" class="w-full" autocomplete="email" onblur="validateEmail()">
                                        <p id="emailError" class="text-red-500 hidden absolute top-full left-0 bg-white p-2 border border-red-500 rounded-md w-full">
                                            Invalid email format. Example: example@gmail.com
                                        </p>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div>Cellphone</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex w-full"><span class="border-r border-blue-200 pr-2">+63</span><span class="w-full"><input type="text" name="stdMobile" id="stdMobile" class="w-full px-1" required></span></div>
                                </div>
                            </div>
                        </div>
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
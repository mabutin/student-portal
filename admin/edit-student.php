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
    st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture,
    ed.course_id,
    cr.course_name,
    yl.year_level, 
    ci.city, ci.address, ci.mobile_number AS contact_mobile_number, ci.email, 
    pi.gender, pi.birthday, pi.age, pi.birth_place, pi.citizenship, pi.height, pi.weight,
    b.place AS baptism_place, b.date AS baptism_date,
    c.place AS confirmation_place, c.date AS confirmation_date,
    k.year AS kindergarten_year, k.name AS kindergarten_name, k.address AS kindergarten_address,
    e.year AS elementary_year, e.name AS elementary_name, e.address AS elementary_address,
    jh.year AS junior_high_year, jh.name AS junior_high_name, jh.address AS junior_high_address,
    sh.year AS senior_high_year, sh.name AS senior_high_name, sh.address AS senior_high_address,
    cg.year AS college_year, cg.name AS college_name, cg.address AS college_address,
    f.name AS father_name, f.address AS father_address, f.company AS father_company, f.company_address AS father_company_address, f.mobile_number AS father_mobile_number,
    m.name AS mother_name, m.address AS mother_address, m.company AS mother_company, m.company_address AS mother_company_address, m.mobile_number AS mother_mobile_number,
    ec.name AS emergency_contact_name, ec.relationship AS emergency_contact_relationship, ec.address AS emergency_contact_address, ec.company AS emergency_contact_company, ec.company_address AS emergency_contact_company_address, ec.mobile_number AS emergency_contact_mobile_number
FROM 
    student_number sn 
    JOIN school_account sa ON sn.student_number_id = sa.student_number_id
    JOIN student_information si ON sa.school_account_id = si.school_account_id
    JOIN students st ON si.student_id = st.student_id
    JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
    JOIN course cr ON ed.course_id = cr.course_id
    JOIN year_level yl ON ed.year_level_id = yl.year_level_id
    JOIN personal_information pi ON si.personal_information_id = pi.personal_information_id
    JOIN baptism b ON pi.baptism_id = b.baptism_id
    JOIN confirmation c ON pi.confirmation_id = c.confirmation_id
    JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
    JOIN educational_attainment ea ON si.educational_attainment_id = ea.educational_attainment_id
    JOIN kindergarten k ON ea.kindergarten_id = k.kindergarten_id
    JOIN elementary e ON ea.elementary_id = e.elementary_id
    JOIN junior_high jh ON ea.junior_high_id = jh.junior_high_id
    JOIN senior_high sh ON ea.senior_high_id = sh.senior_high_id
    JOIN college cg ON ea.college_id = cg.college_id
    JOIN family_record fr ON si.family_record_id = fr.family_record_id
    JOIN father f ON fr.father_id = f.father_id
    JOIN mother m ON fr.mother_id = m.mother_id
    JOIN emergency_contact ec ON fr.emergency_contact_id = ec.emergency_contact_id
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
    <title>Edit Student's Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-[roboto-serif]">
    <div class="flex justify-start overflow-y-hidden">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
            <form action="./update-student.php" method="post">
                <div class="mx-auto p-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div>
                            <h1>Edit Student's Details</h1>
                        </div>
                        <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                        <div class="flex items-end mb-4 gap-4">
                            <div class="ml-4">
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
                            </div>
                            <div>
                                <div class="flex gap-4 items-end">
                                    <div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Student Number:</span>
                                            <input name="student_id" value="<?= $student_details['student_number'] ?>">
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Last Name:</span>
                                            <span><input type="text" class="w-full" name="edited_surname" id="edited_surname" value="<?= $student_details['surname'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">First Name:</span>
                                            <span><input type="text" class="w-full" name="edited_first_name" id="edited_first_name" value="<?= $student_details['first_name'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Middle Name:</span>
                                            <span><input type="text" class="w-full" name="edited_middle_name" id="edited_middle_name" value="<?= $student_details['middle_name'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Course:</span>
                                            <span><?= $student_details['course_name'] ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Suffix:</span>
                                            <span><input type="text" class="w-full" name="edited_suffix" id="edited_suffix" value="<?= $student_details['suffix'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Year Level:</span>
                                            <span><?= isset($student_details['year_level']) ? $student_details['year_level'] : 'Not enrolled' ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Email:</span>
                                            <span><input type="text" class="w-full" name="edited_email" id="edited_email" value="<?= $student_details['email'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Contact Number:</span>
                                            <span><input type="text" class="w-full" name="edited_contact_mobile_number" id="edited_contact_mobile_number" value="<?= $student_details['contact_mobile_number'] ?>"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <div class="font-bold text-lg py-4">
                                    Personal Information
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Gender:</span>
                                    <span><input type="text" class="w-full" name="edited_gender" id="edited_gender" value="<?= $student_details['gender'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Age:</span>
                                    <span><input type="text" class="w-full" name="edited_age" id="edited_age" value="<?= $student_details['age'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address:</span>
                                    <span><input type="text" class="w-full" name="edited_address" id="edited_address" value="<?= $student_details['address'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">City:</span>
                                    <span><input type="text" class="w-full" name="edited_city" id="edited_city" value="<?= $student_details['city'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Birthday:</span>
                                    <span><input type="date" class="w-full" name="edited_birthday" id="edited_birthday" value="<?= $student_details['birthday'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Birth Place:</span>
                                    <span><input type="text" class="w-full" name="edited_birth_place" id="edited_birth_place" value="<?= $student_details['birth_place'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Citizenship:</span>
                                    <span><input type="text" class="w-full" name="edited_citizenship" id="edited_citizenship" value="<?= $student_details['citizenship'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Height:</span>
                                    <span><input type="text" class="w-full" name="edited_height" id="edited_height" value="<?= $student_details['height'] ?>"></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Weight:</span>
                                    <span><input type="text" class="w-full" name="edited_weight" id="edited_weight" value="<?= $student_details['weight'] ?>"></span>
                                </div>
                                <div class="flex gap-8">
                                    <div>
                                        <div class="font-bold text-md py-4">
                                            Bapstism
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Place:</span>
                                            <span><input type="text" class="w-full" name="edited_baptism_place" id="edited_baptism_place" value="<?= $student_details['baptism_place'] ?>">
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Date:</span>
                                            <span><input type="text" class="w-full" name="edited_baptism_date" id="edited_baptism_date" value="<?= $student_details['baptism_date'] ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-md py-4">
                                            Confirmation
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Place:</span>
                                            <span><input type="text" class="w-full" name="edited_confirmation_place" id="edited_confirmation_place" value="<?= $student_details['confirmation_place'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Date:</span>
                                            <span><input type="text" class="w-full" name="edited_confirmation_date" id="edited_confirmation_date" value="<?= $student_details['confirmation_date'] ?>"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto w-1/2">
                                <div class="font-bold text-center text-lg py-4">
                                    Educational Attainment
                                </div>
                                <table class="table-auto border-separate">
                                    <thead>
                                        <tr>
                                            <td class="pr-4">

                                            </td>
                                            <td class="w-40 pr-4 text-center">
                                                <div class="font-bold">
                                                    School Year
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="font-bold">
                                                    Name of School
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="font-bold">
                                                    Address of School
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4">
                                                <div>
                                                    Kindergarten
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full mx-auto text-sm text-center" name="edited_kindergarten_year" id="edited_kindergarten_year" value="<?= $student_details['kindergarten_year'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full" name="edited_kindergarten_name" id="edited_kindergarten_name" value="<?= $student_details['kindergarten_name'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_kindergarten_address" id="edited_kindergarten_address" value="<?= $student_details['kindergarten_address'] ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4">
                                                <div>
                                                    Elementary
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full mx-auto text-sm text-center" name="edited_elementary_year" id="edited_elementary_year" value="<?= $student_details['elementary_year'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full" name="edited_elementary_name" id="edited_elementary_name" value="<?= $student_details['elementary_name'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_elementary_address" id="edited_elementary_address" value="<?= $student_details['elementary_address'] ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4">
                                                <div>
                                                    Junior High School
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full mx-auto text-sm text-center" name="edited_junior_high_year" id="edited_junior_high_year" value="<?= $student_details['junior_high_year'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_junior_high_name" id="edited_junior_high_name" value="<?= $student_details['junior_high_name'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_junior_high_address" id="edited_junior_high_address" value="<?= $student_details['junior_high_address'] ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4">
                                                <div>
                                                    Senior High School
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm text-center">
                                                    <span><input type="text" class="w-full mx-auto text-sm text-center" name="edited_senior_high_year" id="edited_senior_high_year" value="<?= $student_details['senior_high_year'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_senior_high_name" id="edited_senior_high_name" value="<?= $student_details['senior_high_name'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_senior_high_address" id="edited_senior_high_address" value="<?= $student_details['senior_high_address'] ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4">
                                                <div>
                                                    College
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full mx-auto text-sm text-center" name="edited_college_year" id="edited_college_year" value="<?= $student_details['college_year'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4 text-center">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_college_name" id="edited_college_name" value="<?= $student_details['college_name'] ?>"></span>
                                                </div>
                                            </td>
                                            <td class="pr-4">
                                                <div class="mx-auto text-sm">
                                                    <span><input type="text" class="w-full" name="edited_college_address" id="edited_college_address" value="<?= $student_details['college_address'] ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="h-1/2">
                                <div class="font-bold text-lg py-4">
                                    Family Record
                                </div>
                                <div class="flex">
                                    <div id="fatherTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr active" onclick="showTab('fatherTabContent', 'fatherTab', 'motherTab', 'emergencyTab')">
                                        Father
                                    </div>
                                    <div id="motherTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr" onclick="showTab('motherTabContent', 'motherTab', 'fatherTab', 'emergencyTab')">
                                        Mother
                                    </div>
                                    <div id="emergencyTab" class="tab px-4 py-2 cursor-pointer rounded-tl rounded-tr" onclick="showTab('emergencyTabContent', 'emergencyTab', 'fatherTab', 'motherTab')">
                                        Emergency Contact
                                    </div>
                                </div>
                                <div id="fatherTabContent" class="tab-content p-4">
                                    <div class="flex gap-1 mb-2">
                                            <span class="font-bold">Name:</span>
                                            <span><input type="text" class="w-full" name="edited_father_name" id="edited_father_name" value="<?= $student_details['father_name'] ?>"></span>
                                        </div>
                                        <div class="flex gap-1 mb-2">
                                            <span class="font-bold">Contact Number:</span>
                                            <span><input type="text" class="w-full" name="edited_father_mobile_number" id="edited_father_mobile_number" value="<?= $student_details['father_mobile_number'] ?>"></span>
                                        </div>
                                        <div class=" flex gap-1 mb-2">
                                            <span class="font-bold">Address:</span>
                                            <span><input type="text" class="w-full" name="edited_father_address" id="edited_father_address" value="<?= $student_details['father_address'] ?>"></span>
                                        </div>
                                        <div class="flex gap-1 mb-2">
                                            <span class="font-bold">Company connected with:</span>
                                            <span><input type="text" class="w-full" name="edited_father_company" id="edited_father_company" value="<?= $student_details['father_company'] ?>"></span>
                                        </div>
                                        <div class="flex gap-1 mb-2">
                                            <span class="font-bold">Address of Company:</span>
                                            <span><input type="text" class="w-full" name="edited_father_company_address" id="edited_father_company_address" value="<?= $student_details['father_company_address'] ?>"></span>
                                        </div>
                                    </div>
                                <div id="motherTabContent" class="tab-content p-4 hidden">
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Name:</span>
                                        <span><input type="text" class="w-full" name="edited_mother_name" id="edited_mother_name" value="<?= $student_details['mother_name'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Contact Number:</span>
                                        <span><input type="text" class="w-full" name="edited_mother_mobile_number" id="edited_mother_mobile_number" value="<?= $student_details['mother_mobile_number'] ?>"></span>
                                    </div>
                                    <div class="w-full flex gap-1 mb-2">
                                        <span class="font-bold">Address:</span>
                                        <span><input type="text" class="w-full" name="edited_mother_address" id="edited_mother_address" value="<?= $student_details['mother_address'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Company connected with:</span>
                                        <span><input type="text" class="w-full" name="edited_mother_company" id="edited_mother_company" value="<?= $student_details['mother_company'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Address of Company:</span>
                                        <span><input type="text" class="w-full" name="edited_mother_company_address" id="edited_mother_company_address" value="<?= $student_details['mother_company_address'] ?>"></span>
                                    </div>
                                </div>
                                <div id="emergencyTabContent" class="tab-content p-4 hidden">
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Name:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_name" id="edited_emergency_contact_name" value="<?= $student_details['emergency_contact_name'] ?>"></span>
                                    </div>
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Relationship:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_relationship" id="edited_emergency_contact_relationship" value="<?= $student_details['emergency_contact_relationship'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Contact Number:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_mobile_number" id="edited_emergency_contact_mobile_number" value="<?= $student_details['emergency_contact_mobile_number'] ?>"></span>
                                    </div>
                                    <div class="w-full flex gap-1 mb-2">
                                        <span class="font-bold">Address:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_address" id="edited_emergency_contact_address" value="<?= $student_details['emergency_contact_address'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Company connected with:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_company" id="edited_emergency_contact_company" value="<?= $student_details['emergency_contact_company'] ?>"></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Address of Company:</span>
                                        <span><input type="text" class="w-full" name="edited_emergency_contact_company_address" id="edited_emergency_contact_company_address" value="<?= $student_details['emergency_contact_company_address'] ?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-green-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
    <script src="../assets/js/student-profile.js"></script>
</body>
</html>
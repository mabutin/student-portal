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
    sn.student_number, 
    st.first_name, st.surname, st.middle_name, st.suffix, si.status, si.profile_picture,
    ed.course, ed.year_level, ed.semester, 
    ci.city, ci.address, ci.mobile_number AS contact_mobile_number, ci.email, 
    pi.gender, pi.birthday, pi.age, pi.birth_place, pi.citizenship, pi.height, pi.weight,
    b.place AS baptism_place, b.date AS baptism_date,
    c.place AS confirmation_place, c.date AS confirmation_date,
    k.year AS kindergarten_year, k.name AS kindergarten_name, k.address AS kindergarten_address,
    pe.year AS primary_educ_year, pe.name AS primary_educ_name, pe.address AS primary_educ_address,
    s.year AS secondary_year, s.name AS secondary_name, s.address AS secondary_address,
    cg.year AS college_year, cg.name AS college_name, cg.address AS college_address,
    f.name AS father_name, f.address AS father_address, f.company AS father_company, f.company_address AS father_company_address, f.mobile_number AS father_mobile_number,
    m.name AS mother_name, m.address AS mother_address, m.company AS mother_company, m.company_address AS mother_company_address, m.mobile_number AS mother_mobile_number,
    ec.name AS emergency_contact_name, ec.relationship AS emergency_contact_relationship, ec.address AS emergency_contact_address, ec.company AS emergency_contact_company, ec.company_address AS emergency_contact_company_address, ec.mobile_number AS emergency_contact_mobile_number
FROM 
    student_number sn 
    JOIN school_account sa ON sn.student_number_id = sa.student_number_id
    JOIN student_information si ON sa.school_account_id = si.school_account_id
    JOIN students st ON si.students_id = st.students_id
    JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
    JOIN personal_information pi ON si.personal_information_id = pi.personal_information_id
    JOIN baptism b ON pi.baptism_id = b.baptism_id
    JOIN confirmation c ON pi.confirmation_id = c.confirmation_id
    JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
    JOIN educational_attainment ea ON si.educational_attainment_id = ea.educational_attainment_id
    JOIN kindergarten k ON ea.kindergarten_id = k.kindergarten_id
    JOIN primary_educ pe ON ea.primary_educ_id = pe.primary_educ_id
    JOIN secondary s ON ea.secondary_id = s.secondary_id
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
                           Enrolled Subject
                        </div>
                    </div>
                    <button onClick="printStudentDetails();" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">
                        Print
                    </button>
                </div>
            </div>
        <?php if (isset($student_details)): ?>
            <div class="flex gap-4 h-full" id='printable_div_id'>
                <div id="studentDetailsContainer" class="py-10  px-12 h-full">
                    <div class="flex justify-start items-start gap-8">
                        <div>
                            <?php if (empty($student_details['profile_picture'])): ?>
                                <img src="../assets/svg/profile.svg" class="w-48 h-48" alt="">
                            <?php else: ?>
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
                                    <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>.<?= $student_details['suffix'] ?></span>
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
                    <div class="overflow-x-auto mt-4">
                        <table class="table-auto border-separate">
                            <thead>
                                <tr>
                                    <td class="pr-4">
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Gender:</span>
                                            <span><?= $student_details['gender'] ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Citizenship:</span>
                                            <span><?= $student_details['citizenship'] ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4 w-1/3">
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Birthday:</span>
                                            <span><?= $student_details['birthday'] ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Age:</span>
                                            <span><?= $student_details['age'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Address:</span>
                                            <span><?= $student_details['address'] ?> <?= $student_details['city'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Email:</span>
                                            <span><?= $student_details['email'] ?></span>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Contact Number:</span>
                                            <span><?= $student_details['contact_mobile_number'] ?? 'Not available' ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pr-4">
                                        <div class="w-full flex gap-1">
                                            <span class="font-bold w-full flex gap-1"><span>Birth</span> <span>Place:</span></span>
                                            <span><?= $student_details['birth_place'] ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Height:</span>
                                            <span><?= $student_details['height'] ?> cm</span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Weight:</span>
                                            <span><?= $student_details['weight'] ?> kg</span>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2" class="pr-4">
                                        <div class="text-base font-bold">
                                            Baptism
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="text-base font-bold">
                                            Confirmation
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pr-4">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Place:</span>
                                            <span><?= $student_details['baptism_place'] ?? 'Not available' ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-20">
                                        <div class="flex gap-1">
                                            <span class="font-bold">Date:</span>
                                            <span><?= $student_details['baptism_date'] ?? 'Not available' ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="gap-1">
                                            <span class="font-bold">Place:</span>
                                            <span><?= $student_details['confirmation_place'] ?></span>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="gap-1">
                                            <span class="font-bold">Date:</span>
                                            <span><?= $student_details['confirmation_date'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="overflow-x-auto mt-4">
                        <table class="table-auto border-separate">
                            <thead>
                                <tr>
                                    <td colspan="4" class="pr-4 pb-2">
                                        <div class="font-bold text-base">Educational Attainment</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pr-4">

                                    </td>
                                    <td class="w-28 pr-4 text-center">
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
                                            Elementary
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm text-center">
                                            <?= $student_details['primary_educ_year'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm text-center">
                                            <?= $student_details['primary_educ_name'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm">
                                            <?= $student_details['primary_educ_address'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pr-4">
                                        <div>
                                            Secondary
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm text-center">
                                            <?= $student_details['secondary_year'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4 text-center">
                                        <div class="mx-auto text-sm">
                                            <?= $student_details['secondary_name'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm">
                                            <?= $student_details['secondary_address'] ?>
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
                                            <?= $student_details['college_year'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4 text-center">
                                        <div class="mx-auto text-sm">
                                            <?= $student_details['college_name'] ?>
                                        </div>
                                    </td>
                                    <td class="pr-4">
                                        <div class="mx-auto text-sm">
                                            <?= $student_details['college_address'] ?>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="w-full mt-2">
                        <div class="w-full inline-flex justify-center items-center gap-2 my-2">
                            <div class="font-bold">Family Record</div>
                        </div>
                        <div class="w-full flex justify-between gap-4 my-2">
                            <div class="w-full border-r-2 border-blue-200">
                                <div class="text-center font-bold mb-2">
                                    Father
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $student_details['father_name'] ?></span>
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $student_details['father_mobile_number'] ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $student_details['father_address'] ?></span>
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $student_details['father_company'] ?></span>
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $student_details['father_company_address'] ?></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="text-center font-bold mb-2">
                                    Mother
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $student_details['mother_name'] ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $student_details['mother_mobile_number'] ?></span>
                                </div>
                                <div class="w-full flex gap-1 mb-2">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $student_details['mother_address'] ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $student_details['mother_company'] ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $student_details['mother_company_address'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mt-2">
                            <div class="text-center font-bold mb-2">
                                Emergency Contact
                            </div>
                            <div class="my-4">
                                <div class="flex justify-start gap-4 mb-2">
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Name:</span>
                                        <span><?= $student_details['emergency_contact_name'] ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Relationship:</span>
                                        <span><?= $student_details['emergency_contact_relationship'] ?></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Contact Number:</span>
                                        <span><?= $student_details['emergency_contact_mobile_number'] ?></span>
                                    </div>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $student_details['emergency_contact_address'] ?></span>
                                </div>
                                <div class="flex justify-start gap-4 mb-2">
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Company connected with:</span>
                                        <span><?= $student_details['emergency_contact_company'] ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Address of Company:</span>
                                        <span><?= $student_details['emergency_contact_company_address'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full py-4">
                            <div class="w-full flex justify-center items-center text-base">
                                I promise to know and comply with the regulation of OUR LADY OF LOURDES COLLEGE.
                            </div>
                        </div>
                        <div class="grid flex justify-end items-center">
                            <div class="text-center">
                                <?php if (empty($student_details['profile_picture'])): ?>
                                    <img src="../assets/svg/e-sign-sample.svg" class="w-32 h-32" alt="">
                                <?php else: ?>
                                    <img src="<?= $student_details['profile_picture'] ?>" class="w-48 h-48" alt="">
                                <?php endif; ?>
                            </div>
                            <hr class="border border-solid border-black mt-1">
                            <div>
                                <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name']?>. <?= $student_details['suffix'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p>No student details found for the specified ID.</p>
        <?php endif; ?>
    </div>
</body>
</html>
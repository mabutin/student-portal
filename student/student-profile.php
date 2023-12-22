<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

$query = "SELECT
    sn.student_number, sa.school_account_id,
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

$stmt = $conn->prepare($query);

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
    $suffix = $row['suffix'];
    $profilePicturePath = $row['profile_picture'];
    $schoolAccountId = $row['school_account_id'];
    $yearLevel = $row['year_level'];
    $semester = $row['semester'];

    $city = $row['city'];
    $address = $row['address'];
    $contactMobileNumber = $row['contact_mobile_number'];
    $email = $row['email'];

    $gender = $row['gender'];
    $birthday = $row['birthday'];
    $age = $row['age'];
    $birthPlace = $row['birth_place'];
    $citizenship = $row['citizenship'];
    $height = $row['height'];
    $weight = $row['weight'];

    $baptismPlace = $row['baptism_place'];
    $baptismDate = $row['baptism_date'];

    $confirmationPlace = $row['confirmation_place'];
    $confirmationDate = $row['confirmation_date'];

    $kindergartenYear = $row['kindergarten_year'];
    $kindergartenName = $row['kindergarten_name'];
    $kindergartenAddress = $row['kindergarten_address'];

    $primaryEducYear = $row['primary_educ_year'];
    $primaryEducName = $row['primary_educ_name'];
    $primaryEducAddress = $row['primary_educ_address'];

    $secondaryYear = $row['secondary_year'];
    $secondaryName = $row['secondary_name'];
    $secondaryAddress = $row['secondary_address'];

    $collegeYear = $row['college_year'];
    $collegeName = $row['college_name'];
    $collegeAddress = $row['college_address'];

    $fatherName = $row['father_name'];
    $fatherAddress = $row['father_address'];
    $fatherCompany = $row['father_company'];
    $fatherCompanyAddress = $row['father_company_address'];
    $fatherMobileNumber = $row['father_mobile_number'];

    $motherName = $row['mother_name'];
    $motherAddress = $row['mother_address'];
    $motherCompany = $row['mother_company'];
    $motherCompanyAddress = $row['mother_company_address'];
    $motherMobileNumber = $row['mother_mobile_number'];

    $emergencyContactName = $row['emergency_contact_name'];
    $emergencyContactRelationship = $row['emergency_contact_relationship'];
    $emergencyContactAddress = $row['emergency_contact_address'];
    $emergencyContactCompany = $row['emergency_contact_company'];
    $emergencyContactCompanyAddress = $row['emergency_contact_company_address'];
    $emergencyContactMobileNumber = $row['emergency_contact_mobile_number'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadSubmit"])) {
    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (file_exists($_FILES["fileToUpload"]["tmp_name"])) {
            $uniqueFilename = uniqid('profile_', true) . '.' . $imageFileType;
            $target_file = $target_dir . $uniqueFilename;

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $successMessage = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

                $updateProfilePictureSql = "UPDATE student_information SET profile_picture = ? WHERE school_account_id = ?";
                $updateProfilePictureStmt = $conn->prepare($updateProfilePictureSql);
                $updateProfilePictureStmt->bind_param("si", $target_file, $schoolAccountId);
                $updateProfilePictureStmt->execute();
                $updateProfilePictureStmt->close();

                $profilePicturePath = $target_file;
            } else {
                $successMessage = "Sorry, there was an error uploading your file.";
            }
        } else {
            $successMessage = "Uploaded file not found.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="../assets/js/studentDetails.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="w-full flex">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full">
            <div>
                <?php include './topbarStudent.php'; ?>
            </div>
            <div class=" mx-auto p-8">
                <div class="bg-white p-6 rounded-lg border shadow-md">
                    <div class="flex items-end mb-4">
                        <div class="ml-4">
                            <?php if (empty($row['profile_picture'])): ?>
                                <img src="../assets/svg/profile.svg" class="w-48 h-48 mx-auto" alt="">
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($row['profile_picture']) ?>" class="w-48 h-48 mx-auto rounded-full" alt="">
                            <?php endif; ?>
                        </div>
                        <div>
                            <form action="" method="post" enctype="multipart/form-data" class="mb-4">
                                <div class="flex gap-8 items-end">
                                    <div>
                                        <label for="fileToUpload" class="block text-sm font-medium text-gray-700 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            <input type="file" name="fileToUpload" id="fileToUpload" class="hidden" onchange="handleFileSelection(this)">
                                        </label>
                                    </div>
                                    <div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Student Number:</span>
                                            <span><?= $studentNumber ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Name:</span>
                                            <span><?= $surname ?>, <?= $firstName ?> <?= $middleName ?>.<?= $suffix ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Course:</span>
                                            <span><?= $course ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Year Level:</span>
                                            <span><?= $yearLevel ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Email:</span>
                                            <span><?= $email ?></span>
                                        </div>
                                        <div class=" flex gap-1">
                                            <span class="font-bold">Contact Number:</span>
                                            <span><?= $contactMobileNumber ?></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex gap-4 items-center">
                        <span id="selectedFileName"></span>
                        <div>
                            <button type="submit" name="uploadSubmit" id="uploadButton" class="bg-blue-500 text-white px-2 py-1 text-sm rounded-md" style="display:none;">Upload Image</button>
                        </div>
                    </div>
                    <div id="successMessage" class="text-green-600">
                        <?php echo $successMessage; ?>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold text-lg py-4">
                                Personal Information
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Gender:</span>
                                <span><?= $gender ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Age:</span>
                                <span><?= $age ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Address:</span>
                                <span><?= $address ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Birthday:</span>
                                <span><?= $birthday ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Birth Place:</span>
                                <span><?= $birthPlace ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Citizenship:</span>
                                <span><?= $citizenship ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Height:</span>
                                <span><?= $height ?></span>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Weight:</span>
                                <span><?= $weight ?></span>
                            </div>
                            <div class="flex gap-8">
                                <div>
                                    <div class="font-bold text-md py-4">
                                        Bapstism
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Place:</span>
                                        <span><?= $baptismPlace ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Date:</span>
                                        <span><?= $baptismDate ?></span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-md py-4">
                                        Confirmation
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Place:</span>
                                        <span><?= $confirmationPlace ?></span>
                                    </div>
                                    <div class=" flex gap-1">
                                        <span class="font-bold">Date:</span>
                                        <span><?= $confirmationDate ?></span>
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
                                                Elementary
                                            </div>
                                        </td>
                                        <td class="pr-4">
                                            <div class="mx-auto text-sm text-center">
                                                <?= $primaryEducYear ?>
                                            </div>
                                        </td>
                                        <td class="pr-4">
                                            <div class="mx-auto text-sm text-center">
                                                <?= $primaryEducName ?>
                                            </div>
                                        </td>
                                        <td class="pr-4">
                                            <div class="mx-auto text-sm">
                                                <?= $primaryEducAddress ?>
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
                                                <?= $secondaryYear ?>
                                            </div>
                                        </td>
                                        <td class="pr-4 text-center">
                                            <div class="mx-auto text-sm">
                                                <?= $secondaryName ?>
                                            </div>
                                        </td>
                                        <td class="pr-4">
                                            <div class="mx-auto text-sm">
                                                <?= $secondaryAddress ?>
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
                                                <?= $collegeYear ?>
                                            </div>
                                        </td>
                                        <td class="pr-4 text-center">
                                            <div class="mx-auto text-sm">
                                                <?= $collegeName ?>
                                            </div>
                                        </td>
                                        <td class="pr-4">
                                            <div class="mx-auto text-sm">
                                                <?= $collegeAddress ?>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="h-1/2">
                            <div class="font-bold text-lg py-4">
                                Personal Information
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
                                        <span><?= $fatherName ?></span>
                                    </div>
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Contact Number:</span>
                                        <span><?= $fatherMobileNumber ?></span>
                                    </div>
                                    <div class=" flex gap-1 mb-2">
                                        <span class="font-bold">Address:</span>
                                        <span><?= $fatherAddress ?></span>
                                    </div>
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Company connected with:</span>
                                        <span><?= $fatherCompany ?></span>
                                    </div>
                                    <div class="flex gap-1 mb-2">
                                        <span class="font-bold">Address of Company:</span>
                                        <span><?= $fatherCompanyAddress ?></span>
                                    </div>
                                </div>
                            <div id="motherTabContent" class="tab-content p-4 hidden">
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $motherName ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $motherMobileNumber ?></span>
                                </div>
                                <div class="w-full flex gap-1 mb-2">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $motherAddress ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $motherCompany ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $motherCompanyAddress ?></span>
                                </div>
                            </div>
                            <div id="emergencyTabContent" class="tab-content p-4 hidden">
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $emergencyContactName ?></span>
                                </div>
                                <div class="flex gap-1 mb-2">
                                    <span class="font-bold">Relationship:</span>
                                    <span><?= $emergencyContactRelationship ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $emergencyContactMobileNumber ?></span>
                                </div>
                                <div class="w-full flex gap-1 mb-2">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $emergencyContactAddress ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $emergencyContactCompany ?></span>
                                </div>
                                <div class=" flex gap-1 mb-2">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $emergencyContactCompanyAddress ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include './request-update.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/studentSidebar.js"></script>
    <script src="../assets/js/student-profile.js"></script>
</body>
</html>

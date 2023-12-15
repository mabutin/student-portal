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

    $query = "SELECT sn.student_number, st.first_name, st.surname, st.middle_name, st.suffix, si.status, 
    ed.course, ed.year_level, ed.semester, 
    ci.city, ci.address, ci.mobile_number, ci.email, 
    pi.gender, pi.birthday, pi.age, pi.birth_place, pi.citizenship, pi.height, pi.weight,
    b.place, b.date,
    c.place, c.date,
    k.year, k.name, k.address,
    pe.year, pe.name, pe.address,
    s.year, s.name, s.address,
    cg.year, cg.name, cg.address,
    f.name, f.address, f.company, f.company_address, f.mobile_number,
    m.name, m.address, m.company, m.company_address, m.mobile_number,
    ec.name, ec.relationship, ec.address, ec.company, ec.company_address, ec.mobile_number
    FROM student_number sn 
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
    WHERE sn.student_number = ?";


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
                <div class="flex justify-start items-center gap-2">
                    <a href="./student-information.php" aria-label="Go back" id="goBackButton">
                        <img src="../assets/svg/back.svg" style="width: 24px; height: 24px; transition: width 0.3s, height 0.3s;" alt="Go back">
                    </a>
                    <div class="flex justify-start items-center gap-2">
                        Student Details
                    </div>
                </div>
            </div>
        <?php if (isset($student_details)): ?>
            <div class="flex gap-4 h-full">
                <div class="mt-2 shadow-md py-14 pl-12 pr-24 h-full overflow-y-auto" id="studentDetailsContainer" style="width: 816px; height: 700px;">
                    <div class="flex justify-center mb-5">
                        <img src="../assets/svg/ollclogo.svg" class="h-18" alt="">
                    </div>
                    <div class="flex justify-between items-center my-1">
                        <div class=" flex gap-1">
                            <span class="font-bold">Student Number:</span>
                            <span><?= $student_details['student_number'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Status:</span>
                            <span><?= ucfirst(strtolower($student_details['status'])) ?></span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-1">
                        <div class=" flex gap-1">
                            <span class="font-bold">Course:</span>
                            <span><?= $student_details['course'] ?></li></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Year Level:</span>
                            <span><?= $student_details['year_level'] ?></span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-1">
                        <div class=" flex gap-1">
                            <span class="font-bold">Name:</span>
                            <span></strong> <?= $student_details['surname'] ?>, <?= $student_details['first_name'] ?> <?= $student_details['middle_name'] ?>. <?= $student_details['suffix'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Gender:</span>
                            <span><?= $student_details['gender'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Citizenship:</span>
                            <span><?= $student_details['citizenship'] ?></span>
                        </div>
                    </div>
                    <div class=" flex gap-1 my-1">
                        <span class="font-bold">Address:</span>
                        <span><?= $student_details['address'] ?> <?= $student_details['city'] ?></span>
                    </div>
                    <div class="flex justify-start gap-4 items-center my-1">
                        <div class=" flex gap-1">
                            <span class="font-bold">Email:</span>
                            <span><?= $student_details['email'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Contact Number:</span>
                            <span><?= $student_details['mobile_number'] ?></span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-1">
                        <div class=" flex gap-1">
                            <span class="font-bold">Birthday:</span>
                            <span><?= $student_details['birthday'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Age:</span>
                            <span><?= $student_details['age'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Birth Place:</span>
                            <span><?= $student_details['birth_place'] ?></span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Height:</span>
                            <span><?= $student_details['height'] ?> cm</span>
                        </div>
                        <div class=" flex gap-1">
                            <span class="font-bold">Weight:</span>
                            <span><?= $student_details['weight'] ?> kg</span>
                        </div>
                    </div>
                    <div class="flex justify-start gap-10 items-center my-4">
                        <div>
                            <div class="text-base">
                                Baptism
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <div class=" flex gap-1">
                                    <span class="font-bold">Place:</span>
                                    <span><?= $student_details['place'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Date:</span>
                                    <span><?= $student_details['date'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-base">
                                Confirmation
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <div class=" flex gap-1">
                                    <span class="font-bold">Place:</span>
                                    <span><?= $student_details['place'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Date:</span>
                                    <span><?= $student_details['date'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="inline-flex justify-start items-center gap-2 mt-1">
                            <div>Educational Attainment</div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-center ">
                            <div>
                                
                            </div>
                            <div>
                                School Year
                            </div>
                            <div>
                                Name of School
                            </div>
                            <div>
                                Address of School
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Kindergarten
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['year'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['name'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['address'] ?>
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Elementary
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['year'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['name'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['address'] ?>
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Secondary
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['year'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['name'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['address'] ?>
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                College
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['year'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['name'] ?>
                            </div>
                            <div class="mx-auto">
                                <?= $student_details['address'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full inline-flex justify-center items-center gap-2 my-2">
                            <div>Family Record</div>
                        </div>
                        <div class="flex justify-between gap-2">
                            <div class="w-full border-r-2 border-blue-200">
                                <div class="text-center">
                                    Father
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $student_details['name'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $student_details['mobile_number'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $student_details['address'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $student_details['company'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $student_details['company_address'] ?></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="text-center">
                                    Mother
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $student_details['name'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $student_details['mobile_number'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address:</span>
                                    <span><?= $student_details['address'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $student_details['company'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $student_details['company_address'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <div class="text-center">
                                Emergency Contact
                            </div>
                            <div class="flex justify-between">
                                <div class=" flex gap-1">
                                    <span class="font-bold">Name:</span>
                                    <span><?= $student_details['name'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Relationship:</span>
                                    <span><?= $student_details['relationship'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Contact Number:</span>
                                    <span><?= $student_details['mobile_number'] ?></span>
                                </div>
                            </div>
                            <div class=" flex gap-1">
                                <span class="font-bold">Address:</span>
                                <span><?= $student_details['address'] ?></span>
                            </div>
                            <div class="flex justify-between">
                                <div class=" flex gap-1">
                                    <span class="font-bold">Company connected with:</span>
                                    <span><?= $student_details['company'] ?></span>
                                </div>
                                <div class=" flex gap-1">
                                    <span class="font-bold">Address of Company:</span>
                                    <span><?= $student_details['company_address'] ?></span>
                                </div>
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
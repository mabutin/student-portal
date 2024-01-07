<?php

include '../php/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $edited_surname = mysqli_real_escape_string($conn, $_POST['edited_surname']);
    $edited_first_name = mysqli_real_escape_string($conn, $_POST['edited_first_name']);
    $edited_middle_name = mysqli_real_escape_string($conn, $_POST['edited_middle_name']);
    $edited_suffix = mysqli_real_escape_string($conn, $_POST['edited_suffix']);
    $student_number = mysqli_real_escape_string($conn, $_POST['student_id']);
    $edited_email = mysqli_real_escape_string($conn, $_POST['edited_email']);
    $edited_contact_mobile_number = mysqli_real_escape_string($conn, $_POST['edited_contact_mobile_number']);
    $edited_gender = mysqli_real_escape_string($conn, $_POST['edited_gender']);
    $edited_age = mysqli_real_escape_string($conn, $_POST['edited_age']);
    $edited_address = mysqli_real_escape_string($conn, $_POST['edited_address']);
    $edited_city = mysqli_real_escape_string($conn, $_POST['edited_city']);
    $edited_birthday = mysqli_real_escape_string($conn, $_POST['edited_birthday']);
    $edited_birth_place = mysqli_real_escape_string($conn, $_POST['edited_birth_place']);
    $edited_citizenship = mysqli_real_escape_string($conn, $_POST['edited_citizenship']);
    $edited_height = mysqli_real_escape_string($conn, $_POST['edited_height']);
    $edited_weight = mysqli_real_escape_string($conn, $_POST['edited_weight']);
    $edited_baptism_place = mysqli_real_escape_string($conn, $_POST['edited_baptism_place']);
    $edited_baptism_date = mysqli_real_escape_string($conn, $_POST['edited_baptism_date']);
    $edited_confirmation_place = mysqli_real_escape_string($conn, $_POST['edited_confirmation_place']);
    $edited_confirmation_date = mysqli_real_escape_string($conn, $_POST['edited_confirmation_date']);
    $edited_kindergarten_year = mysqli_real_escape_string($conn, $_POST['edited_kindergarten_year']);
    $edited_kindergarten_name = mysqli_real_escape_string($conn, $_POST['edited_kindergarten_name']);
    $edited_kindergarten_address = mysqli_real_escape_string($conn, $_POST['edited_kindergarten_address']);
    $edited_elementary_year = mysqli_real_escape_string($conn, $_POST['edited_elementary_year']);
    $edited_elementary_name = mysqli_real_escape_string($conn, $_POST['edited_elementary_name']);
    $edited_elementary_address = mysqli_real_escape_string($conn, $_POST['edited_elementary_address']);
    $edited_junior_high_year = mysqli_real_escape_string($conn, $_POST['edited_junior_high_year']);
    $edited_junior_high_name = mysqli_real_escape_string($conn, $_POST['edited_junior_high_name']);
    $edited_junior_high_address = mysqli_real_escape_string($conn, $_POST['edited_junior_high_address']);
    $edited_senior_high_year = mysqli_real_escape_string($conn, $_POST['edited_senior_high_year']);
    $edited_senior_high_name = mysqli_real_escape_string($conn, $_POST['edited_senior_high_name']);
    $edited_senior_high_address = mysqli_real_escape_string($conn, $_POST['edited_senior_high_address']);
    $edited_college_year = mysqli_real_escape_string($conn, $_POST['edited_college_year']);
    $edited_college_name = mysqli_real_escape_string($conn, $_POST['edited_college_name']);
    $edited_college_address = mysqli_real_escape_string($conn, $_POST['edited_college_address']);
    $edited_father_name = mysqli_real_escape_string($conn, $_POST['edited_father_name']);
    $edited_father_mobile_number = mysqli_real_escape_string($conn, $_POST['edited_father_mobile_number']);
    $edited_father_address = mysqli_real_escape_string($conn, $_POST['edited_father_address']);
    $edited_father_company = mysqli_real_escape_string($conn, $_POST['edited_father_company']);
    $edited_father_company_address = mysqli_real_escape_string($conn, $_POST['edited_father_company_address']);
    $edited_mother_name = mysqli_real_escape_string($conn, $_POST['edited_mother_name']);
    $edited_mother_mobile_number = mysqli_real_escape_string($conn, $_POST['edited_mother_mobile_number']);
    $edited_mother_address = mysqli_real_escape_string($conn, $_POST['edited_mother_address']);
    $edited_mother_company = mysqli_real_escape_string($conn, $_POST['edited_mother_company']);
    $edited_mother_company_address = mysqli_real_escape_string($conn, $_POST['edited_mother_company_address']);
    $edited_emergency_contact_name = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_name']);
    $edited_emergency_contact_relationship = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_relationship']);
    $edited_emergency_contact_mobile_number = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_mobile_number']);
    $edited_emergency_contact_address = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_address']);
    $edited_emergency_contact_company = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_company']);
    $edited_emergency_contact_company_address = mysqli_real_escape_string($conn, $_POST['edited_emergency_contact_company_address']);
    
    
    $updateQuery = "UPDATE students st
    JOIN student_information si ON st.student_id = si.student_id
    JOIN student_number sn ON st.student_number_id = sn.student_number_id
    JOIN personal_information pi ON si.personal_information_id = pi.personal_information_id
    JOIN baptism b ON pi.baptism_id = b.baptism_id
    JOIN confirmation c ON pi.confirmation_id = c.confirmation_id
    JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
    JOIN educational_attainment ea ON si.educational_attainment_id = ea.educational_attainment_id
    JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
    JOIN course cr ON ed.course_id = cr.course_id
    JOIN year_level yl ON ed.year_level_id = yl.year_level_id
    JOIN kindergarten k ON ea.kindergarten_id = k.kindergarten_id
    JOIN elementary e ON ea.elementary_id = e.elementary_id
    JOIN junior_high jh ON ea.junior_high_id = jh.junior_high_id
    JOIN senior_high sh ON ea.senior_high_id = sh.senior_high_id
    JOIN college cg ON ea.college_id = cg.college_id
    JOIN family_record fr ON si.family_record_id = fr.family_record_id
    JOIN father f ON fr.father_id = f.father_id
    JOIN mother m ON fr.mother_id = m.mother_id
    JOIN emergency_contact ec ON fr.emergency_contact_id = ec.emergency_contact_id

    SET 
        st.surname = ?,
        st.first_name = ?,
        st.middle_name = ?,
        st.suffix = ?,
        ci.email = ?,
        ci.mobile_number = ?,
        pi.gender = ?,
        pi.age = ?,
        ci.address = ?,
        ci.city = ?,
        pi.birthday = ?,
        pi.birth_place = ?,
        pi.citizenship = ?,
        pi.height = ?,
        pi.weight = ?,
        b.place = ?,
        b.date = ?,
        c.place = ?,
        c.date = ?,
        k.year = ?,
        k.name = ?,
        k.address = ?,
        e.year = ?,
        e.name = ?,
        e.address = ?,
        jh.year = ?,
        jh.name = ?,
        jh.address = ?,
        sh.year = ?,
        sh.name = ?,
        sh.address = ?,
        cg.year = ?,
        cg.name = ?,
        cg.address = ?,
        f.name = ?,
        f.mobile_number = ?,
        f.address = ?,
        f.company = ?,
        f.company_address = ?,
        m.name = ?,
        m.mobile_number = ?,
        m.address = ?,
        m.company = ?,
        m.company_address = ?,
        ec.name = ?,
        ec.relationship = ?,
        ec.mobile_number = ?,
        ec.address = ?,
        ec.company = ?,
        ec.company_address = ?
    WHERE sn.student_number = ?";

    $updateStmt = mysqli_prepare($conn, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param ($updateStmt, "sssssssssssssssssssssssssssssssssssssssssssssssssss", 
            $edited_surname, 
            $edited_first_name, 
            $edited_middle_name, 
            $edited_suffix, 
            $edited_email, 
            $edited_contact_mobile_number,
            $edited_gender,
            $edited_age,
            $edited_address,
            $edited_city,
            $edited_birthday,
            $edited_birth_place,
            $edited_citizenship,
            $edited_height,
            $edited_weight,
            $edited_baptism_place,
            $edited_baptism_date,
            $edited_confirmation_place,
            $edited_confirmation_date,
            $edited_kindergarten_year,
            $edited_kindergarten_name,
            $edited_kindergarten_address,
            $edited_elementary_year,
            $edited_elementary_name,
            $edited_elementary_address,
            $edited_junior_high_year,
            $edited_junior_high_name,
            $edited_junior_high_address,
            $edited_senior_high_year,
            $edited_senior_high_name,
            $edited_senior_high_address,
            $edited_college_year,
            $edited_college_name,
            $edited_college_address,
            $edited_father_name,
            $edited_father_mobile_number,
            $edited_father_address,
            $edited_father_company,
            $edited_father_company_address,
            $edited_mother_name,
            $edited_mother_mobile_number,
            $edited_mother_address,
            $edited_mother_company,
            $edited_mother_company_address,
            $edited_emergency_contact_name,
            $edited_emergency_contact_relationship,
            $edited_emergency_contact_mobile_number,
            $edited_emergency_contact_address,
            $edited_emergency_contact_company,
            $edited_emergency_contact_company_address,
            $student_number
        );

        if (mysqli_stmt_execute($updateStmt)) {
            header("Location: student-details.php?student_id=$student_number");
            exit();
        } else {
            echo "Error updating record: " . mysqli_stmt_error($updateStmt);
            echo "<br>SQL Query: " . $updateQuery;
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}
?>

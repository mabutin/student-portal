<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

// Function to enroll a student
function enrollStudent($course, $year_level, $student_id, $class_name)
{
    global $conn;

    // Perform any necessary validation or checks here

    // Insert enrolled students into available classes
    $query = "INSERT INTO studentclass (classid, classname, yearlevelid, student_id)
              SELECT c.classid, ?, ?, s.year_level, s.student_id
              FROM students s
              JOIN class c ON s.course = c.course
              WHERE s.course = ? AND s.year_level = ? AND c.classname = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $class_name, $year_level, $course, $year_level, $class_name);
    $stmt->execute();
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enroll'])) {
    // Get form data
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $student_id = $_POST['student_id'];
    $class_name = $_POST['class_name'];

    // Call the enrollment function
    enrollStudent($course, $year_level, $student_id, $class_name);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head content -->
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

            <!-- Your HTML content goes here, including the form -->
            <form method="post" action="">
                <!-- Form fields for selecting course, year level, student, and class -->
                Course: <input type="text" name="course" required><br>
                Year Level: <input type="text" name="year_level" required><br>
                Student ID: <input type="text" name="student_id" required><br>
                Class Name: <input type="text" name="class_name" required><br>

                <!-- Submit button -->
                <input type="submit" name="enroll" value="Enroll">
            </form>
        </div>
    </div>

    <script src="../assets/js/adminSidebar.js" defer></script>
</body>

</html>

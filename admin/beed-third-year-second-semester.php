<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'guest';

include '../php/conn.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveSubjects'])) {
    if (isset($_POST['selected_subjects'])) {
        $selectedSubjects = $_POST['selected_subjects'];
        $saveAsDefault = isset($_POST['saveAsDefault']) ? 1 : 0;

        $insertQuery = "INSERT INTO open_subjects (subject_id, course_id, year_level_id, semester_tbl_id, isDefault) VALUES (?, 4, 3, 2, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $subjectId, $saveAsDefault);
        
            foreach ($selectedSubjects as $subjectId) {
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        
            mysqli_stmt_close($stmt);
            header('Location: manage-subject.php');
        } else {
            $message = "Error preparing the statement: " . mysqli_error($conn);
        }
    } else {
        
    }
}

$sql = "SELECT s.*, c.course_name, yl.year_level, st.semester
    FROM subjects s
    JOIN course c ON s.course_id = c.course_id
    JOIN semester_tbl st ON s.semester_tbl_id = st.semester_tbl_id
    JOIN year_level yl ON s.year_level_id = yl.year_level_id
    WHERE c.course_id = 4";

$result = mysqli_query($conn, $sql);
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mt-4 table-container overflow-y-auto" style="height: 860px; width:fit-content">
                    <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-start items-center gap-2">
                                <a href="./manage-subject.php" aria-label="Go back" id="goBackButton">
                                    <img src="../assets/svg/back.svg" style="width: 24px; height: 24px; transition: width 0.3s, height 0.3s;" alt="Go back">
                                </a>
                                <span>
                                    Open Subjects for Third Year - Second Semester
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
                        <?php if (!empty($message)) : ?>
                            <div id="successMessage">
                                <p><?php echo $message; ?></p>
                            </div>
                            <script>
                                setTimeout(function() {
                                    var successMessage = document.getElementById('successMessage');
                                    successMessage.style.display = 'none';
                                }, 1500);
                            </script>
                        <?php endif; ?>
                        <table>
                            <thead>
                                <tr class="justify-between bg-blue-200">
                                    <td style="width: 3%;" class="text-center"></td>
                                    <td style="width: 22%;" class="text-center">Code</td>
                                    <td style="width: 50%;" class="text-center">Subject</td>
                                    <td style="width: 20%;" class="text-center">Year Level</td>
                                    <td style="width: 5%;" class="text-center">Units</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td class=""><input type="checkbox" name="selected_subjects[]" value="<?php echo $row['subject_id']; ?>"></td>
                                            <td class="text-center"><?php echo $row['code']; ?></td>
                                            <td class="text-center"><?php echo $row['name']; ?></td>
                                            <td class="text-center"><?php echo $row['year_level']; ?></td>
                                            <td class="text-center"><?php echo $row['unit']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No subjects found</td>
                                    </tr>
                                <?php endif; ?>
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

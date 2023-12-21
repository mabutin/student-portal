<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../login/student/login.php");
    exit();
}

include '../php/conn.php';

date_default_timezone_set('Asia/Manila');

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, st.suffix, si.status, ed.course, si.profile_picture, sa.school_account_id
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
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
    $suffix = $row['suffix'];
    $profilePicturePath = $row['profile_picture'];
    $schoolAccountId = $row['school_account_id'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
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
            <div class="container mx-auto p-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
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
                                <div class="flex gap-4 items-end">
                                    <div>
                                        <label for="fileToUpload" class="block text-sm font-medium text-gray-700 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            <input type="file" name="fileToUpload" id="fileToUpload" class="hidden" onchange="handleFileSelection(this)">
                                        </label>
                                    </div>
                                    <span id="selectedFileName"></span>
                                    <div>
                                        <button type="submit" name="submit" id="uploadButton" class="bg-blue-500 text-white px-2 py-1 text-sm rounded-md" style="display:none;">Upload Image</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="successMessage" class="text-green-600">
                        <?php echo $successMessage; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/studentSidebar.js"></script>
</body>
</html>

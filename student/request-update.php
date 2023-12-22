<?php

    if (!isset($_SESSION['student_number'])) {
        header("Location: ../login/student/login.php");
        exit();
    }

    include '../php/conn.php';

    date_default_timezone_set('Asia/Manila');

    $studentNumber = $_SESSION['student_number'];

    $successMessage = "";

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $message = trim($_POST["message"]);
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $insertQuery = "INSERT INTO request_messages (student_number, message, request_datetime) VALUES (?, ?, NOW())";
        $insertStmt = $conn->prepare($insertQuery);
        
        if (!$insertStmt) {
            die("Error preparing statement: " . $conn->error);
        }

        if (!$insertStmt->bind_param("is", $studentNumber, $message)) {
            die("Error binding parameters: " . $insertStmt->error);
        }

        if (!$insertStmt->execute()) {
            $successMessage = "Error saving request message: " . $insertStmt->error;
        } else {
            $successMessage = "Request message saved successfully.";
        }

        $sqlError = $insertStmt->error;
        if (!empty($sqlError)) {
            die("SQL Error after execution: " . $sqlError);
        }

        $insertStmt->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="w-full flex justify-center mt-2">
        <button onclick="openUpdateModal()" class="rounded-sm py-2 px-4 font-medium border border-blue-500 hover:bg-blue-400 hover:text-white">Update Details</button>
    </div>
    <div id="updateModal" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-black bg-opacity-50 items-center justify-center">
        <div class="relative p-4 w-auto top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="flex items-center justify-between border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Request for updating information
                        </h3>
                    </div>
                    <div>
                        <i>
                            <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400 cursor-pointer">Note: Some of your information cannot be changed, and some can be considered with a valid reason. Details that can be changed include email, contact number, address, height, weight, parent's details aside from name, and emergency contact details.</p>
                        </i>
                    </div>
                    <div class="mt-2">
                        Tell us what you want to change.
                    </div>
                    <div>
                        <textarea id="message" name="message" rows="4" class="w-full p-2 border border-blue-300 rounded-md focus:outline-none resize-none"></textarea>
                    </div>
                    <div class="flex items-center justify-center p-4 gap-4">
                        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                        <button type="button" onclick="closeUpdateModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
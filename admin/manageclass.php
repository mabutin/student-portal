<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'admin';

// Include your database connection code
include '../php/conn.php';

// Function to create a class and insert into the class table
function createClass($classname, $yearlevelid, $schoolyearid)
{
    global $conn;

    $query = "INSERT INTO class (schoolyearid, classname, yearlevelid) VALUES (?, ?, ?)";
    
    $statement = $conn->prepare($query);

    $statement->bind_param("iss", $schoolyearid, $classname, $yearlevelid);

    $result = $statement->execute();

    if ($result) {

    } else {
        echo "Error creating class: " . $conn->error;
    }

    $statement->close();
}

// Get year levels from the database
$yearLevelsQuery = "SELECT year_level_id, year_level FROM year_level";
$yearLevelsResult = $conn->query($yearLevelsQuery);

$yearLevels = [];
while ($row = $yearLevelsResult->fetch_assoc()) {
    $yearLevels[$row['year_level_id']] = $row['year_level'];
}

// Check if the form for creating a class is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate user inputs (you may need to enhance this based on your requirements)
    $classname = htmlspecialchars($_POST['classname']);
    $yearlevelid = intval($_POST['yearlevelid']);
    $schoolyearid = intval($_POST['schoolyearid']);

    // Call the function to create and insert the class
    createClass($classname, $yearlevelid, $schoolyearid);

    // Set a flag to indicate successful form submission
    $result = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Class</title>
    <style>
        /* Add your styles for the popup here */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
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

            <!-- Your HTML content goes here -->

            <!-- Assuming you have a form for creating a class -->
            <form method="POST" action="">
                <label for="classname">Class Name:</label>
                <input type="text" name="classname" required>

                <label for="yearlevelid">Year Level:</label>
                <select name="yearlevelid" required>
                    <?php foreach ($yearLevels as $id => $levelName) : ?>
                        <option value="<?= $id ?>"><?= $levelName ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="schoolyearid">School Year:</label>
                <input type="number" name="schoolyearid" required>

                <button type="submit">Create Class</button>
            </form>

            <!-- Popup (modal) for success message -->
            <div id="successPopup" class="popup">
                <p>Class created successfully!</p>
                <button onclick="closePopup()">Close</button>
            </div>

            <!-- Include your scripts -->
            <script src="../assets/js/student-information-menu.js"></script>
            <script src="../assets/js/studentSidebar.js"></script>
            <script>
                // Function to display the success popup
                function displaySuccessPopup() {
                    document.getElementById('successPopup').style.display = 'block';
                }

                // Function to close the success popup
                function closePopup() {
                    document.getElementById('successPopup').style.display = 'none';
                }

                // Add an event listener to trigger the display of the popup when the form is submitted successfully
                document.addEventListener('DOMContentLoaded', function () {
                    <?php if (isset($result) && $result) : ?>
                        displaySuccessPopup();
                    <?php endif; ?>
                });
            </script>
        </div>
    </div>
</body>

</html>

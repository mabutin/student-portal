<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'Admin';

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

    if (!$result) {
        echo "Error creating class: " . $conn->error;
    }

    $statement->close();
}

// Function to retrieve classes from the database
function getClasses()
{
    global $conn;

    $query = "SELECT id, classname, yearlevelid, schoolyearid FROM class";
    $result = $conn->query($query);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error fetching classes: " . $conn->error;
        return [];
    }
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

// Get the classes
$classes = getClasses();
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

            <div class="w-full h-full flex gap-5 pb-10">
                <!-- Start of left div -->
                <div class="flex flex-col w-2/3">
                    <!-- Assuming you have a form for creating a class -->
                    <form method="POST" action="" class="mb-4">
                        <section class="mt-8 font-sans">
                            <h2 class="text-2xl font-bold mb-3 uppercase">Manage Class</h2>

                            <div class="bg-blue-300 px-6 py-4 rounded-lg shadow-md w-full inline-flex gap-7">
                                <div>
                                    <label for="classname" class="mb-2 text-base font-medium text-gray-900">Class Name:</label>
                                    <input type="text" name="classname" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 p-0.5" required>
                                </div>

                                <div>
                                    <label for="yearlevelid" class="mb-2 text-base font-medium text-gray-900">Year Level:</label>
                                    <select name="yearlevelid" class="w-32 bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-0.5" required>
                                        <?php foreach ($yearLevels as $id => $levelName) : ?>
                                            <option value="<?= $id ?>"><?= $levelName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label for="yearlevelid" class="mb-2 text-base font-medium text-gray-900">Year Level:</label>
                                    <select name="yearlevelid" class="w-32 bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-0.5" required>
                                        <?php foreach ($yearLevels as $id => $levelName) : ?>
                                            <option value="<?= $id ?>"><?= $levelName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label for="schoolyearid" class="mb-2 text-base font-medium text-gray-900">School Year:</label>
                                    <input type="number" name="schoolyearid" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-0.5" required>
                                </div>

                                <div class="py-2 pl-10">
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 text-center inline-flex items-center">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </span>
                                        Create Class
                                    </button>
                                </div>
                            </div>
                        </section>
                    </form>

                    <section class="border border-blue-300 font-sans relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="py-4 bg-blue-300">
                            <h2 class="px-6 text-lg font-semibold">Class List</h2>
                        </div>

                        <!-- Display the classes in a table -->
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr class="border-b border-blue-300">
                                    <th scope="col" class="px-6 py-3 border-r border-blue-300">Class ID</th>
                                    <th scope="col" class="px-6 py-3 border-r border-blue-300">Class Name</th>
                                    <th scope="col" class="px-6 py-3 border-r border-blue-300">Year Level</th>
                                    <th scope="col" class="px-6 py-3 border-r border-blue-300">School Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($classes as $class) : ?>
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-6 py-3 border-b border-r border-blue-300"><?= $class['id'] ?></td>
                                        <td class="px-6 py-3 border-b border-r border-blue-300"><?= $class['classname'] ?></td>
                                        <td class="px-6 py-3 border-b border-r border-blue-300"><?= $yearLevels[$class['yearlevelid']] ?? 'Unknown' ?></td>
                                        <td class="px-6 py-3 border-b border-r border-blue-300"><?= $class['schoolyearid'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
                <!-- End of left div -->

                <div class="bg-white border border-blue-300 rounded-lg shadow-md w-1/3" style="margin-top: 75px;">
                    <div class="bg-blue-300 px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold">List of Students</h3>
                    </div>

                    <div class="h-auto p-4">
                        <div class="flex">
                            <p>No selected class</p>
                        </div>
                    </div>
                </div>

            </div>





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
                document.addEventListener('DOMContentLoaded', function() {
                    <?php if (isset($result) && $result) : ?>
                        displaySuccessPopup();
                    <?php endif; ?>
                });
            </script>
        </div>
    </div>
</body>

</html>
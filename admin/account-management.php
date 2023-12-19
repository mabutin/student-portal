<?php
session_start();

function formatDateHeading($date) {
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    if ($date === $today) {
        return 'Today';
    } elseif ($date === $yesterday) {
        return 'Yesterday';
    } else {
        return date('F j, Y', strtotime($date));
    }
}

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'];

include '../php/conn.php';

// Handle search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$selectQuery = "SELECT id, username, email, userType FROM usertbl";

if (!empty($search)) {
    $selectQuery .= " WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = mysqli_query($conn, $selectQuery);

$users = [];
if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Handle form submission for saving to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

    // Example of using prepared statements
    $stmt = $conn->prepare("INSERT INTO usertbl (username, email, userType) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $usertype);
    $stmt->execute();
    $stmt->close();

    if ($result) {
        // Add history entry
        $historyEntry = mysqli_real_escape_string($conn, "'$usertype' created a new user account named '$username' with the role of '$usertype'");
        $insertHistoryQuery = "INSERT INTO history (entry, date_time) VALUES ('$historyEntry', NOW())";
        mysqli_query($conn, $insertHistoryQuery);

        header('Location: account-management.php');
        exit();
    } else {
        // Example of improved error handling
        $error = "Error: Unable to add user. Please try again later.";
        error_log("SQL Error: " . mysqli_error($conn));
    }
}

// Fetch history entries
$historyEntries = [];
$historyQuery = "SELECT entry, date_time FROM history ORDER BY date_time DESC LIMIT 5";
$historyResult = mysqli_query($conn, $historyQuery);

if ($historyResult) {
    $historyEntries = mysqli_fetch_all($historyResult, MYSQLI_ASSOC);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Account Management</title>
</head>

<body class="font-[roboto-serif]" style="background: rgba(118, 163, 224, 0.1);">
    <div class="flex justify-start">
        <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div class="mb-4">
                <?php include './topbar.php'; ?>
            </div>
            <div class="w-full bg-white p-4 border border-blue-100 gap-2">
                <div>
                    Manage Accounts
                </div>
                <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                <div>
                    <div class="flex justify-start items-center gap-2 text-base">
                        <form action="" method="post" onsubmit="return validateForm()">
                            <div class="flex justify-start items-center gap-2 text-base">
                                <div>
                                    Username:
                                </div>
                                <div class="text-sm p-1 border border-blue-200 rounded-md w-64 text-xs">
                                    <input type="text" id="username" name="username" placeholder="Enter a username" class="px-1 w-full">
                                </div>
                                <div class="flex justify-start gap-2 items-center">
                                    <div>Email</div>
                                    <div class="w-64 text-sm p-1 border border-blue-200 rounded-md flex justify-between items-center relative gap-2">
                                        <input type="text" name="email" id="email" class="px-1 w-full" autocomplete="email" onblur="validateEmail()" placeholder="Enter email">
                                        <p id="emailError" class="text-red-500 hidden absolute top-full left-0 bg-white p-2 border border-red-500 rounded-md w-full">
                                            Invalid email format. Example: example@gmail.com
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-start gap-2 items-center">
                                    <div>Role:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md">
                                        <select name="usertype" id="usertype" class="w-24">
                                            <option value="admin">Admin</option>
                                            <option value="admission">Admission</option>
                                            <option value="faculty">Faculty</option>
                                            <option value="college_registrar">College Registrar</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <button class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Add user</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="flex mt-4">
                        <div class="w-1/2">
                            <div class="mt-4">
                                <form action="" method="get" class="flex items-center">
                                    <label for="search" class="mr-2">Search:</label>
                                    <input type="text" id="search" name="search" class="p-1 border border-blue-200 rounded-md" placeholder="Enter username or email">
                                    <button type="submit" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Search</button>
                                </form>
                            </div>
                            <div class="grid grid-cols-4 px-2" style="background: #8EAFDC; overflow-x: auto;">
                                <div class="flex justify-center">ID</div>
                                <div class="flex justify-center">Username</div>
                                <div class="flex justify-center">Email</div>
                                <div class="flex justify-center">Role</div>
                            </div>
                            <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($users as $index => $user): ?>
                                    <div class="grid grid-cols-4 px-2 <?= $index % 2 === 0 ? 'bg-white-100' : '#9DBAE1' ?>">
                                        <div class="flex justify-center"><?= $user['id']; ?></div>
                                        <div class="flex justify-center"><?= $user['username']; ?></div>
                                        <div class="flex justify-center"><?= $user['email']; ?></div>
                                        <div class="flex justify-center"><?= $user['userType']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- History Section -->
                        <div class="w-1/2 ml-4">
                            <h2 class="text-lg font-semibold mb-2">History</h2>
                            <?php
                            $currentDateHeading = null;

                            foreach ($historyEntries as $entry) {
                                $entryDateTime = new DateTime($entry['date_time']);
                                $currentDateTime = new DateTime();
                                $interval = $currentDateTime->diff($entryDateTime);

                                $formattedDateTime = $entryDateTime->format('F j, Y, g:i a');
                                $entryDate = $entryDateTime->format('Y-m-d');
                                $timeAgo = formatDateHeading($entryDate);

                                // Display date heading if it's a new date
                                if ($currentDateHeading !== $entryDate) {
                                    echo "<p class='font-semibold mt-2'>$timeAgo</p>";
                                    $currentDateHeading = $entryDate;
                                }

                                echo "<p class='ml-2'>{$entry['entry']} - $timeAgo at $formattedDateTime</p>";
                            }

                            // Display 'No new notifications' if there are no history entries
                            if (empty($historyEntries)) {
                                echo "<div>No new notifications</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js"></script>
    <script src="../assets/js/account-management.js"></script>
</body>

</html>

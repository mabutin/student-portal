<?php
session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: ../login/admin/login.php');
        exit();
    }

    $usertype = $_SESSION['usertype'];

    include '../php/conn.php';

    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $selectQuery = "SELECT id, username, email, usertype FROM usertbl";

    if (!empty($search)) {
        $selectQuery .= " WHERE username LIKE ? OR email LIKE ?";
        $stmt = mysqli_prepare($conn, $selectQuery);
        $searchParam = "%{$search}%";
        mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    } else {
        $result = mysqli_query($conn, $selectQuery);
        $users = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

    $stmt = $conn->prepare("INSERT INTO usertbl (username, email, userType) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $usertype);
    $stmt->execute();
    $stmt->close();

    if ($result) {
        $historyEntry = mysqli_real_escape_string($conn, "Username '$username' added with role of $usertype by admin");
        $insertHistoryQuery = "INSERT INTO history (entry, date_time) VALUES ('$historyEntry', NOW())";
        mysqli_query($conn, $insertHistoryQuery);

        header('Location: account-management.php');
        exit();
    } else {
        $error = "Error: Unable to add user. Please try again later.";
        error_log("SQL Error: " . mysqli_error($conn));
    }
}

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
    <div class="w-full flex justify-start">
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
                <div class="w-full flex justify-start gap-2">
                    <div class="w-3/4 border-r-2 border-blue-300 gap-2 grid pr-2">
                        <div>
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
                                        <div>
                                            <select name="usertype" id="roleMenu" class="text-sm p-1 border border-blue-200 rounded-md w-full"></select>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Add user</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-start items-center gap-2">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="flex items-center gap-2">
                                <label for="search" class="mr-2">Search:</label>
                                <input type="text" id="search" name="search" class="p-1 border border-blue-200 rounded-md" placeholder="Enter username or email" value="<?= $searchValue; ?>">
                                <?php if (!empty($searchValue)): ?>
                                    <button type="submit" class="p-2 bg-red-500 rounded-md text-xs text-white hover:bg-red-700" name="clearSearch">Clear</button>
                                <?php else: ?>
                                    <button type="submit" class="p-2 bg-blue-500 rounded-md text-xs text-white hover:bg-blue-700">Search</button>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="px-2 py-1 bg-blue-300">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                    </tr>
                                </thead>
                                <tbody id="table-container">
                                    <?php foreach ($users as $index => $user): ?>
                                        <tr class="px-2 py-1 <?= $index % 2 === 0 ? 'bg-white-500' : 'bg-blue-100' ?>">
                                            <td class="text-center"><?= $index + 1; ?></td>
                                            <td class="text-center"><?= $user['username']; ?></td>
                                            <td class="text-center"><?= $user['email']; ?></td>
                                            <td class="text-center"><?= isset($user['usertype']) ? $user['usertype'] : ''; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="">
                        <div class="font-semibold">
                            History
                        </div>
                        <div class="w-full ml-4">
                            <?php if (!empty($groupedHistory)): ?>
                                <?php foreach ($groupedHistory as $date => $entries): ?>
                                    <div class="font-semibold mt-2"><?= formatDateHeading($date) ?></div>
                                    <?php foreach ($entries as $historyEntry): ?>
                                        <div><?= $historyEntry['action']; ?></div>
                                        <div class="text-xs text-gray-500"><?= date('F j, Y, g:i a', strtotime($historyEntry['datetime'])); ?></div>
                                        <hr class="my-2">
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div>No new history entries</div>
                            <?php endif; ?>
                        </div>
                        <div class="w-1/2 ml-4">
                            <h2 class="text-lg font-semibold mb-2">History</h2>
                            <?php
                            foreach ($historyEntries as $entry) {
                                echo "<p>{$entry['entry']} - {$entry['date_time']}</p>";
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

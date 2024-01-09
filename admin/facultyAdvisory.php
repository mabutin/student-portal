<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'Admin';

// Include your database connection code
include '../php/conn.php';

// Fetch faculty details from the professor_details table
$sql = "SELECT surname, first_name, middle_name FROM professor_details";
$result = $conn->query($sql);

$facultyList = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $facultyList[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            <div class="w-full"><img src="../assets/img/faculty-banner.png" class="w-full" alt=""></div>
            <div class="w-full flex justify-center mt-4 mb-14">
                <div class="container mx-auto mt-8 p-4 font-semibold mb-4 max-w-6xl shadow-2xl rounded-md bg-white">
                    <div class="text-4xl font-bold text-center mb-8">FACULTY LIST</div>

                    <?php if (!empty($facultyList)) : ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Surname</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facultyList as $faculty) : ?>
                                    <tr>
                                        <td class='border px-4 py-2'><?php echo $faculty["surname"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $faculty["first_name"]; ?></td>
                                        <td class='border px-4 py-2'><?php echo $faculty["middle_name"]; ?></td>
                                        <!-- Add more cells for additional columns -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p class="text-center">No faculty members found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script src="../assets/js/adminSidebar.js" defer></script>
    </body>
</html>

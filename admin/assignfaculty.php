<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/admin/login.php');
    exit();
}

$usertype = $_SESSION['usertype'] ?? 'guest';

include '../php/conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Assign Faculty</title>
</head>

<body class="font-serif">
    <form action="process_assignment.php" method="post">
        <div class="flex">
            <div>
                <?php include './sidebar.php'; ?>
            </div>
            <div class="w-full py-4 px-4">
                <div>
                    <?php include './topbar.php'; ?>
                </div>

                <section>
                    <h2>Assign Faculty to Subject</h2>

                      <!-- Subject Selection -->
                      <label for="subject">Select Subject:</label>
                    <select name="subject" required>
                        <?php
                        // Fetch subjects from the database
                        $sqlSubjects = "SELECT subject_id, name FROM subjects";
                        $resultSubjects = $conn->query($sqlSubjects);

                        if ($resultSubjects->num_rows > 0) {
                            while ($row = $resultSubjects->fetch_assoc()) {
                                echo "<option value='" . $row['subject_id'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No subjects available</option>";
                        }

                        $resultSubjects->close();
                        ?>
                    </select>

                    <!-- Year Level Selection -->
                    <label for="year_level">Select Year Level:</label>
                    <select name="year_level" required>
                        <!-- Populate year levels dynamically -->
                        <option value="1">First Year</option>
                        <option value="2">Second Year</option>
                        <!-- Add more options as needed -->
                    </select>

                    <!-- Class Selection -->
                    <label for="class">Select Class:</label>
                    <input type="text" name="class" required>

                    <!-- Semester Selection -->
                    <label for="semester">Select Semester:</label>
                    <select name="semester" required>
                        <option value="1">First Semester</option>
                        <option value="2">Second Semester</option>
                        <!-- Add more options as needed -->
                    </select>

                   <!-- Faculty Member Selection -->
                   <label for="faculty">Select Faculty Member:</label>
                    <select name="faculty" required>
                        <?php
                        // Fetch faculty members from the database
                        $sqlFaculty = "SELECT professor_details_id, surname, first_name, middle_name FROM professor_details";
                        $resultFaculty = $conn->query($sqlFaculty);

                        if ($resultFaculty->num_rows > 0) {
                            while ($row = $resultFaculty->fetch_assoc()) {
                                echo "<option value='" . $row['professor_details_id'] . "'>" . $row['surname'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No faculty members available</option>";
                        }

                        $resultFaculty->close();
                        ?>
                    </select>

                    <!-- Submit Button -->
                    <button type="submit">Assign Faculty</button>
                </section>
            </div>
        </div>
    </form>

    <script src="../assets/js/studentSidebar.js"></script>
</body>

</html>

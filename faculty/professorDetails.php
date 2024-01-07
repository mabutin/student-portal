<?php
// Include your database connection file here
include '../php/conn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Professor Details Form</title>
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
            <div>
                <section>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the form is submitted
                    $lastName = $_POST['last_name'];
                    $firstName = $_POST['first_name'];
                    $middleName = $_POST['middle_name'];
                    // Assuming suffix is not collected in your form, you can add it if needed

                    // Insert the professor details into the database
                    $sql = "INSERT INTO professor_details (surname, first_name, middle_name) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                    if (!$stmt) {
                        die("Error in SQL query: " . $conn->error);
                    }

                    $stmt->bind_param("sss", $lastName, $firstName, $middleName);
                    $stmt->execute();

                    $stmt->close();

                    echo '<p class="text-green-600">Successfully added professor details.</p>';
                }
                ?>
                    <form method="post" action="">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" required>

                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" required>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" name="middle_name" required>

                    <!-- You can add more fields if needed -->

                    <button type="submit">Submit</button>
                </form>
            </section>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
</body>

</html>

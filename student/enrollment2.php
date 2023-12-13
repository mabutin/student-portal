<?php


session_start();
include_once('config.php');
$query1 = "select  * from login";
$result1 = mysqli_query($conn, $query1);



// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user_name'])) {
    header('location: login.php');
}
include 'config.php';
$username = $_SESSION['user_name'];

// Query to retrieve student information based on the username
$select = " SELECT * FROM login WHERE username = '$username'  ";
$result = mysqli_query($conn, $select);

if ($result) {
    // Check if a matching record is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Retrieve and display the student information

        $name = $row['name'];
        $studentID = $row['student_id'];
        $usertype = $row['user_type'];
        $bday = $row['bday'];
        $address = $row['address'];
    } else {
        // No matching record found
        echo "Student information not found.";
    }
} else {
    // Error in the database query
    echo "Error: " . mysqli_error($conn);
}

if (isset($_POST['enter'])) {
    // Form has been submitted, process the selected year level and semester
    $selectedYear = $_POST['year'];
    $selectedSemester = $_POST['semester'];

    $update = "UPDATE login SET year = '" . $selectedYear . "', semester = '" . $selectedSemester . "' WHERE student_id = " . $studentID;
    //$update = "INSERT INTO login (year,semester) VALUES ('$selectedYear','$selectedSemester')"; 
    mysqli_query($conn, $update);
    header('location: enrollment.php');

    // Now, you can display the "Choose Subjects for Enrollment" section

    // ... (Rest of your code for subject selection)


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-image: url('images/img4.jpg');

            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 300px 0;
            /*Pwede ma adjust yung width or height nung picture header sa padding boss! */
            text-align: center;
            /* Center-align text horizontally */
            background-attachment: fixed;

        }



        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-around;
            background-image: linear-gradient(to top, rgba(1, 0, 0, 0), rgba(59, 79, 190, 1));
            padding: 10px;
            overflow: visible;
        }

        .menu-icon {
            display: none;
            cursor: pointer;
        }

        .navbar-links {
            display: flex;

        }

        .logo {
            width: 300px;
            height: 85px;
            margin-right: 10px;
            margin-left: 30px;
        }

        .navbar a {
            text-decoration: none;
            color: #fff;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        @media (max-width: 767px) {

            /* Apply responsive styles for screens up to 768px wide */
            .menu-icon {
                display: block;
            }

            .navbar-links {
                display: none;
                flex-direction: column;
                background-color: rgba(255, 255, 255, 0);
                position: absolute;
                top: 100px;
                right: 0;
                left: 0;
                padding: 10px;
                overflow: auto;
            }

            .navbar-links a {
                padding: 5px;
                color: black;
            }

            .navbar.active .navbar-links {
                display: flex;
            }
        }

        .enrollment-table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;

        }

        .enrollment-table th,
        .enrollment-table td {
            border: 1px solid #ddd;
            padding: 10px;

        }

        .enrollment-table th {
            background-color: #f2f2f2;
        }

        /* magigitna yung mga input tsaka checkbox*/
        .enrollment-table td {
            text-align: center;
        }

        .header {

            width: 70%;
            margin: 0 auto;
            background-color: rgba(59, 79, 190, .9);
            border-radius: 20px;
        }

        .student-form {

            width: 100%;
            margin: 0 auto;
            padding-top: 20px;

        }

        .info-wrapper {
            width: 100%;
            color: black;
            font-size: large;
            margin: 0 auto;
            padding: 20px;


            text-align: center;

        }

        .four-column-info {
            display: flex;
            justify-content: start;
            width: 80%;
            margin: 0 auto;


        }

        .column {


            width: 24%;
            /* Each column takes 24% of the width */
            display: flex;
            flex-direction: column;

        }

        .info-item {
            text-align: center;
        }

        .info {
            text-align: left;

        }

        .course-dropdown {
            border-radius: 10px;
            padding: 10px;
            width: 100%;
        }

        .row {
            display: flex;
            width: 60%;
            margin: 0 auto;
        }

        .label {
            width: 20%;
            margin: auto 0;
        }

        .dropdown {
            width: 80%;
        }

        .label span {
            color: red;
        }

        .logo {
            width: 300px;
            /* Adjust the width as needed */

            /* To maintain the aspect ratio */
            margin-right: 10px;
            /* Add some spacing between the logo and "Enrollment" link */
        }

        .table-info {
            border-collapse: collapse;
            margin: 0 auto;
            margin-bottom: 20px;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000000;
            padding: 8px;
            text-align: center;
            min-width: 20px;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .enroll-subject table {
            width: 100%;
            /* Set the table width to 100% */
            border-collapse: collapse;
            margin: 0 auto;
            /* Add more table styles as needed */
        }

        .enroll-subject th,
        .enroll-subject td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            /* Add more styles for table cells (th and td) */
        }

        .delete-button {
            padding: 5px;
            background-color: rgba(255, 0, 0, .9);
            border-radius: 10px;
            color: black;
        }

        .delete-button:hover {
            background-color: rgba(255, 0, 0, .7);
            color: white;
        }

        .update-button {
            padding: 5px;

            background-color: rgba(65, 206, 43, 0.7);
            border-radius: 10px;
            color: black;
        }

        .update-button:hover {
            background-color: rgba(65, 206, 43, 0.7);
            color: white;
        }
    </style>
</head>

<body>
<button onclick="openModal()">Sign Up / Login</button>

<!-- The Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Add your sign-up/login form or content here -->
        <h2>Welcome!</h2>
        <!-- Add your sign-up/login form or content here -->
    </div>
</div>
    <!-- Header with background image -->
    <div class="header">
        <div class="navbar">
            <div>
                <img src="images/logo4.png" alt="Your Logo" class="logo">
            </div>
            <div class="menu-icon" onclick="toggleMenu()">☰</div>
            <div class="navbar-links">
                <a class="active" href="enrollment.php">Enrollment</a>
                <a href="javascript:void(0);" onclick="confirmLogout();" class="logout">Logout</a>
                <a href="admin.php">Admin</a>
            </div>
        </div>

       


        <script>

            function openModal() {
                var modal = document.getElementById('myModal');
                modal.style.display = 'block';
                }

            function closeModal() {
                var modal = document.getElementById('myModal');
                modal.style.display = 'none';
            }

            window.onclick = function (event) {
                var modal = document.getElementById('myModal');
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }

            function toggleMenu() {
                var navbar = document.querySelector('.navbar');
                navbar.classList.toggle('active');
            }

            function confirmLogout() {
                if (confirm("Are you sure you want to log out?")) {
                    window.location.href = 'logout.php'; // Redirect to the logout page if confirmed
                }
            }

            /* function deleteRow(button) {
                 if (confirm("Are you sure you want to delete this subject?")) {
                     // Get the row to be deleted
                     var row = button.parentNode.parentNode;

                     // Delete the row
                     row.parentNode.removeChild(row);
                 }
             }   */

            function confirmEnter() {
                if (confirm("This will Update or Add your Semester and Year Level in your personal Information")) {
                    // User clicked "OK," submit the form
                    document.querySelector('form').submit();
                } else {
                    // User clicked "Cancel," do nothing
                }
            }

            function confirmEnroll() {
                if (confirm("If you hit ok or enter it will submit all the subject. Please check again if you missed subjects that you need to take.")) {
                    // User clicked "OK," submit the form
                    document.querySelector('form').submit();
                } else {
                    // User clicked "Cancel," do nothing
                }
            }

            // Add an event listener to the window
            window.addEventListener('beforeunload', function(e) {
                // Perform an automatic logout when leaving the enrollment page
                window.location.href = 'logout.php';
            });
        </script>

        <div class="info-wrapper">
            <h2 style="text-align: center;">Student's Information</h2><br>

            <table class="table-info" style="text-align:center; ">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Semester</th>
                </tr>


                <?php
                while ($rows1 = mysqli_fetch_assoc($result1)) {
                    if ($rows1['username'] === $username) {
                        // Display data only if the username matches
                ?>
                        <tr>
                            <td style="width: 10px;"><?php echo $rows1['student_id']; ?></td>
                            <td><?php echo $rows1['name']; ?></td>
                            <td><?php echo $rows1['course']; ?></td>
                            <td><?php echo $rows1['year']; ?></td>
                            <td><?php echo $rows1['semester']; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>


            </table>



            <div class="student-form" style="text-align: center;">
                <form action="" method="POST">



                    <div class="row">
                        <div class="label">
                            <strong>Year Level:</strong> <span>*</span>
                        </div>
                        <div class="dropdown">
                            <select class="course-dropdown" name="year">
                                <option value="1st Year">Year 1</option>
                                <option value="2nd Year">Year 2</option>
                                <option value="3rd Year">Year 3</option>
                                <option value="4th Year">Year 4</option>

                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="label">
                            <strong>Semester:</strong> <span>*</span>
                        </div>
                        <div class="dropdown">
                            <select class="course-dropdown" name="semester">
                                <option value="1st">First Semester</option>
                                <option value="2nd">Second Semester</option>


                            </select>
                        </div>
                    </div>
                    <br>
                    <input style="margin-top:10px; padding: 15px; border-radius:15%; 
                     box-shadow: 0 0 20px rgba(0, 0, 0, 0.4); cursor: pointer;" type="submit" name="enter" value="Enter" class="enroll" onclick="confirmEnter()">
                </form>
                <br> <br>
                <div class="enroll-subject" style="text-align: center; margin: auto 0;">
                    <form action="insert_subject.php" method="POST">
                        <table>

                            <tr>
                                <th></th>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Subject Unit</th>
                                <th>Semester</th>
                                <th>Year Level</th>
                                <!-- <th>Operation</th>  -->

                            </tr>
                            <?php
                            // Query to retrieve student information based on the username
                            $selectStudentInfo = "SELECT * FROM login WHERE username = '$username'";
                            $resultStudentInfo = mysqli_query($conn, $selectStudentInfo);

                            if ($resultStudentInfo) {
                                // Check if a matching record is found
                                if (mysqli_num_rows($resultStudentInfo) > 0) {
                                    $row = mysqli_fetch_assoc($resultStudentInfo);
                                    $course = $row['course'];
                                    $yearlvl = $row['year'];
                                    $semester = $row['semester']; // Assuming the course is stored in a column called 'course'
                                    //$selectedYear = $_POST['year'];
                                    //$selectedSemester = $_POST['semester'];

                                    // Query to select subjects based on the user's course (e.g., BSIT)
                                    $selectSubjectsQuery = "SELECT * FROM subject WHERE course = '$course' AND semester ='$semester' AND year = '$yearlvl'  " ;
                                    $resultSubjects = mysqli_query($conn, $selectSubjectsQuery);

                                    if ($resultSubjects) {
                                        // Display the subjects for the user's course
                                        echo '<h2>Subjects for ' . $course . '</h2>';

                                    

                                        while ($subjectRow = mysqli_fetch_assoc($resultSubjects)) {

                                            // Display data only if the username matches
                            ?>
                                            <tr>
                                                <td class="chckbox">
                                                    <input type="checkbox" name="selected_subjects[]" value="<?php echo $subjectRow['sub_id']; ?>">
                                                </td>
                                                <td><?php echo $subjectRow['sub_name']; ?></td>
                                                <td><?php echo  $subjectRow['sub_code']; ?></td>
                                                <td><?php echo $subjectRow['sub_unit']; ?></td>
                                                <td><?php echo $subjectRow['semester']; ?></td>
                                                <td><?php echo $subjectRow['year']; ?></td>
                                                <!--  <td> 
                                                    <button class="delete-button" onclick="deleteRow(this)">Delete</button>
                                                </td> -->

                                            </tr>
                            <?php
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                } else {
                                    echo "Student information not found.";
                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }


                            ?>
                        </table>
                        <input style="margin-top:10px; padding: 15px; border-radius:15%; 
                     box-shadow: 0 0 20px rgba(0, 0, 0, 0.4); cursor: pointer;" type="submit" name="submit" value="Submit" class="enroll" onclick="confirmEnroll()">
                    </form>
                </div>

                <br><br>





            </div>

        </div>
</body>

</html>
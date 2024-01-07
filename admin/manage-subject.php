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
    <title>Admin dashboard</title>
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
            <div class="mt-4">
                <div class="w-full bg-white p-4 border border-blue-100 gap-2 font-semibold">
                    <div class="flex justify-start items-center gap-2">
                        <span>
                            Manage Subjects
                        </span>
                    </div>
                    <hr class="w-full h-px my-2 border-0 dark:bg-gray-700" style="background-color: #8EAFDC;">
                    <div class="w-full">
                        <ul class="flex">
                            <li id="bsitTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bsit' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bsit' ? 'font-semibold' : ''; ?>" onclick="showContent('bsit')">BSIT</a>
                            </li>
                            <li id="bshmTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bshm' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bshm' ? 'font-semibold' : ''; ?>" onclick="showContent('bshm')">BSHM</a>
                            </li>
                            <li id="bscrimTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bscrim' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bscrim' ? 'font-semibold' : ''; ?>" onclick="showContent('bscrim')">BSCRIM</a>
                            </li>
                            <li id="beedTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'beed' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'beed' ? 'font-semibold' : ''; ?>" onclick="showContent('beed')">BEED</a>
                            </li>
                            <li id="bsbaTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bsba' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bsba' ? 'font-semibold' : ''; ?>" onclick="showContent('bsba')">BSBA</a>
                            </li>
                            <li id="bseEnglishTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bseEnglish' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bseEnglish' ? 'font-semibold' : ''; ?>" onclick="showContent('bseEnglish')">BSE-English</a>
                            </li>
                            <li id="bseMathematicsTab" class="cursor-pointer px-4 py-2 <?php echo $usertype === 'bseMathematics' ? 'border-b-2 border-blue-500' : ''; ?>">
                                <a href="#" class="text-gray-700 <?php echo $usertype === 'bseMathematics' ? 'font-semibold' : ''; ?>" onclick="showContent('bseMathematics')">BSE-Mathematics</a>
                            </li>
                        </ul>
                        <div id="bsitContent" class="<?php echo $usertype === 'bsit' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bsitPrevPage" onclick="changePage('bsit', -1)" disabled>&lt;</button>
                                <span id="bsitCurrentPage">Year 1</span>
                                <button id="bsitNextPage" onclick="changePage('bsit', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, os.open_subject_id, s.code, s.name, s.unit
                                                            FROM open_subjects os
                                                            JOIN subjects s ON os.subject_id = s.subject_id
                                                            WHERE os.course_id = 1
                                                            AND os.year_level_id = 1
                                                            AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    
                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsit-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bshmContent" class="<?php echo $usertype === 'bshm' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bshmPrevPage" onclick="changePage('bshm', -1)" disabled>&lt;</button>
                                <span id="bshmCurrentPage">Year 1</span>
                                <button id="bshmNextPage" onclick="changePage('bshm', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bshm-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 2
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <div>First Semester</div>
                                                <div class="flex justify-center">
                                                    <button onclick="location.href='./bshm-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                        Add Subject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <table class="table-auto w-full">
                                                    <thead>
                                                        <tr class="justify-between bg-blue-200">
                                                            <td style="width: 20%;" class="text-center">Code</td>
                                                            <td style="width: 50%;" class="text-center">Subject</td>
                                                            <td style="width: 30%;" class="text-center">Units</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include '../php/conn.php';

                                                        $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                        FROM open_subjects os
                                                        JOIN subjects s ON os.subject_id = s.subject_id
                                                        WHERE os.course_id = 2
                                                        AND os.year_level_id = 4
                                                        AND os.semester_tbl_id = 1;";

                                                        $result = mysqli_query($conn, $sql);

                                                        if ($result) {

                                                            if (mysqli_num_rows($result) > 0) {
                                                                $row_number = 0;
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                    echo "<tr class='$row_class'>
                                                                            <td class='pl-16'>{$row['code']}</td>
                                                                            <td class='text-center'>{$row['name']}</td>
                                                                            <td class='text-center'>{$row['unit']}</td>
                                                                        </tr>";
                                                                    $row_number++;
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='3' class='text-center'>No subjects found</td></tr>";
                                                            }
                                                        } else {
                                                            echo "Error: " . mysqli_error($conn);
                                                        }

                                                        mysqli_close($conn);
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <div>Second Semester</div>
                                                <div class="flex justify-center">
                                                    <button onclick="location.href='./bshm-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                        Add Subject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <table class="table-auto w-full">
                                                    <thead>
                                                        <tr class="justify-between bg-blue-200">
                                                            <td style="width: 20%;" class="text-center">Code</td>
                                                            <td style="width: 50%;" class="text-center">Subject</td>
                                                            <td style="width: 30%;" class="text-center">Units</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include '../php/conn.php';

                                                        $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                        FROM open_subjects os
                                                        JOIN subjects s ON os.subject_id = s.subject_id
                                                        WHERE os.course_id = 2
                                                        AND os.year_level_id = 4
                                                        AND os.semester_tbl_id = 2;";

                                                        $result = mysqli_query($conn, $sql);

                                                        if ($result) {

                                                            if (mysqli_num_rows($result) > 0) {
                                                                $row_number = 0;
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                    echo "<tr class='$row_class'>
                                                                            <td class='pl-16'>{$row['code']}</td>
                                                                            <td class='text-center'>{$row['name']}</td>
                                                                            <td class='text-center'>{$row['unit']}</td>
                                                                        </tr>";
                                                                    $row_number++;
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='3' class='text-center'>No subjects found</td></tr>";
                                                            }
                                                        } else {
                                                            echo "Error: " . mysqli_error($conn);
                                                        }

                                                        mysqli_close($conn);
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bscrimContent" class="<?php echo $usertype === 'bscrim' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bscrimPrevPage" onclick="changePage('bscrim', -1)" disabled>&lt;</button>
                                <span id="bscrimCurrentPage">Year 1</span>
                                <button id="bscrimNextPage" onclick="changePage('bscrim', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bscrim-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 7
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <div class="flex justify-between mb-2">
                                                    <div>First Semester</div>
                                                    <div class="flex justify-center">
                                                        <button onclick="location.href='./bscrim-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                            Add Subject
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <table class="table-auto w-full">
                                                        <thead>
                                                            <tr class="justify-between bg-blue-200">
                                                                <td style="width: 20%;" class="text-center">Code</td>
                                                                <td style="width: 50%;" class="text-center">Subject</td>
                                                                <td style="width: 30%;" class="text-center">Units</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            include '../php/conn.php';

                                                            $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                            FROM open_subjects os
                                                            JOIN subjects s ON os.subject_id = s.subject_id
                                                            WHERE os.course_id = 7
                                                            AND os.year_level_id = 4
                                                            AND os.semester_tbl_id = 1;";

                                                            $result = mysqli_query($conn, $sql);

                                                            if ($result) {

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    $row_number = 0;
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                        echo "<tr class='$row_class'>
                                                                                <td class='pl-16'>{$row['code']}</td>
                                                                                <td class='text-center'>{$row['name']}</td>
                                                                                <td class='text-center'>{$row['unit']}</td>
                                                                            </tr>";
                                                                        $row_number++;
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='3' class='text-center'>No subjects found</td></tr>";
                                                                }
                                                            } else {
                                                                echo "Error: " . mysqli_error($conn);
                                                            }

                                                            mysqli_close($conn);
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between mb-2">
                                                    <div>Second Semester</div>
                                                    <div class="flex justify-center">
                                                        <button onclick="location.href='./bscrim-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                            Add Subject
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <table class="table-auto w-full">
                                                        <thead>
                                                            <tr class="justify-between bg-blue-200">
                                                                <td style="width: 20%;" class="text-center">Code</td>
                                                                <td style="width: 50%;" class="text-center">Subject</td>
                                                                <td style="width: 30%;" class="text-center">Units</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            include '../php/conn.php';

                                                            $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                            FROM open_subjects os
                                                            JOIN subjects s ON os.subject_id = s.subject_id
                                                            WHERE os.course_id = 7
                                                            AND os.year_level_id = 4
                                                            AND os.semester_tbl_id = 2;";

                                                            $result = mysqli_query($conn, $sql);

                                                            if ($result) {

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    $row_number = 0;
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                        echo "<tr class='$row_class'>
                                                                                <td class='pl-16'>{$row['code']}</td>
                                                                                <td class='text-center'>{$row['name']}</td>
                                                                                <td class='text-center'>{$row['unit']}</td>
                                                                            </tr>";
                                                                        $row_number++;
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='3' class='text-center'>No subjects found</td></tr>";
                                                                }
                                                            } else {
                                                                echo "Error: " . mysqli_error($conn);
                                                            }

                                                            mysqli_close($conn);
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="beedContent" class="<?php echo $usertype === 'beed' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="beedPrevPage" onclick="changePage('beed', -1)" disabled>&lt;</button>
                                <span id="beedCurrentPage">Year 1</span>
                                <button id="beedNextPage" onclick="changePage('beed', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./beed-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 4
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bsbaContent" class="<?php echo $usertype === 'bsba' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bsbaPrevPage" onclick="changePage('bsba', -1)" disabled>&lt;</button>
                                <span id="bsbaCurrentPage">Year 1</span>
                                <button id="bsbaNextPage" onclick="changePage('bsba', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 1
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsba-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 3
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bseEnglishContent" class="<?php echo $usertype === 'bseEnglish' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bseEnglishPrevPage" onclick="changePage('bseEnglish', -1)" disabled>&lt;</button>
                                <span id="bseEnglishCurrentPage">Year 1</span>
                                <button id="bseEnglishNextPage" onclick="changePage('bseEnglish', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-fourth-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsee-fourth-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 5
                                                    AND os.year_level_id = 4
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bseMathematicsContent" class="<?php echo $usertype === 'bseMathematics' ? '' : 'hidden'; ?>">
                            <div class="pagination">
                                <button id="bseMathematicsPrevPage" onclick="changePage('bseMathematics', -1)" disabled>&lt;</button>
                                <span id="bseMathematicsCurrentPage">Year 1</span>
                                <button id="bseMathematicsNextPage" onclick="changePage('bseMathematics', 1)">></button>
                            </div>
                            <div class="pageContent" data-page="1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-first-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-first-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 1
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-second-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-second-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 2
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>First Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-third-year-first-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 1;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <div>Second Semester</div>
                                            <div class="flex justify-center">
                                                <button onclick="location.href='./bsem-third-year-second-semester.php'" class="p-2 bg-blue-100 rounded-md text-xs text-black hover:text-white hover:bg-blue-600">
                                                    Add Subject
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr class="justify-between bg-blue-200">
                                                        <td style="width: 20%;" class="text-center">Code</td>
                                                        <td style="width: 50%;" class="text-center">Subject</td>
                                                        <td style="width: 30%;" class="text-center">Units</td>
                                                        <td style="width: 10%;" class="text-center">Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../php/conn.php';

                                                    $sql = "SELECT os.open_subject_id, s.code, s.name, s.unit
                                                    FROM open_subjects os
                                                    JOIN subjects s ON os.subject_id = s.subject_id
                                                    WHERE os.course_id = 6
                                                    AND os.year_level_id = 3
                                                    AND os.semester_tbl_id = 2;";

                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        $row_number = 0; 

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $row_class = ($row_number % 2 == 0) ? 'bg-white' : 'bg-blue-100';
                                                                
                                                                $openSubjectsId = isset($row['open_subject_id']) ? $row['open_subject_id'] : '';

                                                                echo "<tr class='$row_class'>
                                                                        <td class='pl-16'>{$row['code']}</td>
                                                                        <td class='text-center'>{$row['name']}</td>
                                                                        <td class='text-center'>{$row['unit']}</td>
                                                                        <td class='text-center'>
                                                                            <button onclick=\"deleteSubject('{$openSubjectsId}')\">Delete</button>
                                                                        </td>
                                                                    </tr>";
                                                                $row_number++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No subjects found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pageContent hidden" data-page="4">
                                <p>This is the content for BSE-MATHEMATICS - Page 4</p>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/adminSidebar.js" defer></script>
    <script>
        function showContent(tab) {
            document.getElementById('bsitContent').classList.add('hidden');
            document.getElementById('bshmContent').classList.add('hidden');
            document.getElementById('bscrimContent').classList.add('hidden');
            document.getElementById('beedContent').classList.add('hidden');
            document.getElementById('bsbaContent').classList.add('hidden');
            document.getElementById('bseEnglishContent').classList.add('hidden');
            document.getElementById('bseMathematicsContent').classList.add('hidden');

            document.getElementById(tab + 'Content').classList.remove('hidden');

            document.getElementById('bsitTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('bshmTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('bscrimTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('beedTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('bsbaTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('bseEnglishTab').classList.remove('border-b-2', 'border-blue-500');
            document.getElementById('bseMathematicsTab').classList.remove('border-b-2', 'border-blue-500');

            document.getElementById(tab + 'Tab').classList.add('border-b-2', 'border-blue-500');
        }
        function changePage(tab, step) {
            const currentPage = parseInt(document.getElementById(tab + 'CurrentPage').innerText.split(' ')[1]);
            const nextPage = currentPage + step;

            document.querySelector(`#${tab}Content .pageContent[data-page="${currentPage}"]`).classList.add('hidden');
            document.querySelector(`#${tab}Content .pageContent[data-page="${nextPage}"]`).classList.remove('hidden');

            document.getElementById(tab + 'CurrentPage').innerText = `Year ${nextPage}`;

            document.getElementById(tab + 'PrevPage').disabled = nextPage === 1;
            document.getElementById(tab + 'NextPage').disabled = nextPage === 4;
        }
        document.addEventListener('DOMContentLoaded', function () {
            showContent('bsit');
        });
        function deleteSubject(openSubjectsId) {
            if (confirm("Are you sure you want to delete this subject?")) {
                window.location.href = "delete_subject.php?id=" + openSubjectsId;
            }
        }
    </script>
</body>

</html>

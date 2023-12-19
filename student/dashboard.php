<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Student Dashboard</title>
    <style>
       section {
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #648EC7;
            color: white;
        }
        </style>
</head>

<body class="font-serif"> 
    <form action="../login/student/logout.php">
        <div class="flex">
    <div>
            <?php include './sidebar.php'; ?>
        </div>
        <div class="w-full py-4 px-4">
            <div>
                <?php include './topbar.php'; ?>
            </div>
            <div>
                <section>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Student ID:</strong> 123456</p>
        <p><strong>Program:</strong> Computer Science</p>
    </section>
      <section>
        <h2>Subjects</h2>
        <table>
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Units</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CSCI101</td>
                    <td>Introduction to Computer Science</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>MATH201</td>
                    <td>Calculus II</td>
                    <td>3</td>
                </tr>
                <!-- Add more rows for additional courses -->
            </tbody>
        </table>
    </section>
            </div>
            </div>
</div>

  
    
            </div>
    </form>

    
    <script src="../assets/js/studentSidebar.js"></script>
</body>

</html>
<?php
session_start();

include '../../php/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM usertbl WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['usertype'] = $row['usertype'];

        if ($row['usertype'] === "admin") {
            header("Location: ../../admin/admin_dash.php");
            exit();
        } elseif ($row['usertype'] === "dean") {
            header("Location: ../../admin/admin_dash.php");
            exit();
        } else {
            header("Location: ../student/dashboard.hmtl");
            exit();
        }
    } else {
        $error_message = "Invalid username or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <form action="" method="post">
        <div class="w-screen h-screen inline flex ">
            <div class="justify-center items-center inline-flex w-full" style="background: url('../../assets/img/school1.png') no-repeat center/cover;">
                <div class="p-14 bg-white rounded-2xl drop-shadow-xl border border-blue-800 border-opacity-60">
                    <div class="justify-center items-center inline-flex gap-1">
                        <div><img src="../../assets/svg/ollcLogoNoName.svg" class="w-[56px]" alt="OLLC Logo"></div>
                        <div class="text-2xl font-medium">INFORMATION SYSTEM</div>
                    </div>
                    <div class="my-4">
                    <form action="/ollcInformationSystem/login.php" method="post">
                        <div class='text-xl text-center font-medium'>ADMIN LOGIN</div>
                        <div class='text-lg py-2 font-medium'>Username:</div>
                        <div class='text-lg p-1 border border-blue-200 rounded-md'><input type="text" id='username' name='username' autoComplete='none' class='w-full p-1' placeholder='Enter your Username'/></div>
                        <div class='text-lg py-2 font-medium'>Password:</div>
                        <div class='text-lg p-1 border border-blue-200 rounded-md'><input type="password" id='password' name='password' autoComplete='none' class='w-full p-1' placeholder='Enter your Password' /></div>
                        
                        <?php if (!empty($error_message)) : ?>
                            <div class="text-red-500 text-sm mt-2"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <div class="w-full inline-flex justify-center">
                            <button type="submit" name="submit" value="Login" class="bg-blue-400 mt-2 py-2 px-8 shadow justify-center items-center inline-flex gap-2 text-white rounded-full hover:bg-blue-600 hover:font-semibold">Login</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Topbar</title>
</head>
<body>
<form action="../login/student/logout.php" method="post">
        <div class="flex py-4 px-14 justify-between items-center relative">
            <div>
                <div><img src="../assets/svg/ollclogo.svg" alt=""></div>
            </div>
            <div class="inline-flex justify-between items-center gap-4">
                <div class="relative">
                    <!-- Add an id to the button to target it in JavaScript -->
                    <button id="profileDropdown" class="text-base btn hover:bg-blue-400 hover:text-white font-semibold focus:outline-none" type="button">
                        <?php echo htmlspecialchars($firstName . ' ' . $middleName . ' ' . $surname, ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                    <!-- Dropdown content -->
                    <div id="profileDropdownContent" class="hidden absolute z-10 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">
                        <!-- Add your dropdown content here -->
                        <a href="student-profile.php" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Profile</a>
                        <a href="#" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the dropdown button and content
            const dropdownButton = document.getElementById('profileDropdown');
            const dropdownContent = document.getElementById('profileDropdownContent');

            // Show/hide the dropdown content on button click
            dropdownButton.addEventListener('click', function () {
                dropdownContent.classList.toggle('hidden');
            });

            // Hide the dropdown content if the user clicks outside of it
            document.addEventListener('click', function (event) {
                if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
                    dropdownContent.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
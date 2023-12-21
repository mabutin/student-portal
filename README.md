# Student Portal for Our Lady of Lourdes College

The Student Portal serves as a comprehensive platform that seamlessly integrates the Information System, Enrollment System, Grading Management System, and Record Management System.

Key Features:

User Management: Addition of new users with designated roles.
Role-Based Access: The sidebar displays access levels tailored to each user's role, ensuring visibility only to relevant features.

Roles and Accessibilities:

Admin: Access to all integrated systems.
Admission: Dashboard and Student Information Page.
Faculty: Dashboard and Faculty Page.
College Registrar: Access to the Enrollment Page.
Registrar: Access to the Record Management Page.

# Information System

Contributors:

Documents: Borinaga, De Ocampo, Santos.

Main Programmer: Millamina.

Assistant Programmer: Mabutin.

The Information System plays a crucial role in the admission process, collecting student information and providing them with a student account before proceeding to the enrollment process.

Features:

For students, the system offers a pre-registration phase where users input basic information and admission form for completing their information. Additionally, a student profile allows users to view personal information, upload a 2x2 picture, and e-signature for ID purposes.

Upcoming Features:

Request buttons for updating information.
Request for downloading soft copies.

Administrators have access to:

Student Information: View all student lists, click on student numbers to access detailed information, including a 2x2 picture and e-signature. Printing of student information in legal size is available.

Future Feature:
- Edit button for updating student information.
- Notifications: Admin and admission roles can view all recent students who completed pre-registration, admission forms, and enrollment.
- Requests: Admin and admission roles can review all student requests for information updates or soft copy downloads.
- Clickable requests that redirect to student details.
- Upon updating, students are notified.
- Granting requests for downloading soft copies triggers a notification to students.

# Steps to run the system

1. Download the file.
2. Create database named "student_portal".
3. Open xampp apache and sql.
4. Import the sql file from a folder named sql.

To access the website
- Search http://localhost/student-portal/website/index.html

Try Pre-registration
- Try filling up Pre-registration form.
- Login your credentials to access admission page.
- FIll up the admission form then submit to access enrollment process.

To try student profile search http://localhost/student-portal/student/student-profile.php.
- Try uploading your 2x2 picture.

To access admin
- Search http://localhost/student-portal/login/admin/login.php
- Login credentials ( Username: dev@user, Password: dev123).

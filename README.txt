STUDENT RECORD SYSTEM — PHP + MYSQL VERSION

This is a real server-backed starter project, not a browser-only demo. It has student signup, hashed passwords, PHP sessions, MySQL records, file uploads, teacher review actions, and private file downloads. The database starts empty: no sample students, sample teachers, sample submissions, or fake approvals.

REQUIREMENTS
- XAMPP for Windows (Apache, PHP, MySQL/MariaDB)
- PHP extensions: pdo_mysql, fileinfo

INSTALL ON XAMPP
1. Extract the student-record-website folder into C:\xampp\htdocs\
   It should become C:\xampp\htdocs\student-record-website\index.php
2. Open XAMPP Control Panel and start Apache and MySQL.
3. Visit http://localhost/phpmyadmin
4. Choose Import and import database.sql from this folder. It creates an empty database and tables.
5. Open config.php. The defaults match a typical XAMPP install (DB user root, blank password). Change DB_PASS if your MySQL root account has a password.
6. Make sure the uploads folder is writable by Apache/PHP. Do not remove uploads/.htaccess.
7. Visit http://localhost/student-record-website/ and create a student account.

TEACHER SIGNUP AND SIGN-IN
1. Open config.php and replace CHANGE-THIS-TEACHER-CODE with a private code shared only with teachers. Do not publish or share the code with students.
2. A teacher opens http://localhost/student-record-website/teacher_signup.php, enters their details and the private access code, then creates an account.
3. On the sign-in page, select Teacher and sign in with the teacher username/email and password.
4. The teacher dashboard lists real student submissions. Teachers can click a filename to download it, approve it, or return it with a required remark. Students see the updated status and teacher remarks on their own dashboard.
5. The sign-in page separates Student and Teacher roles, so a student account cannot sign in through the Teacher selection and vice versa.


HOW IT WORKS
- Students can register with full name, optional student ID, email, username, and password.
- Passwords are stored using PHP password_hash; login uses password_verify.
- Students upload PDF, DOC, DOCX, JPG, or PNG files (max 10 MB).
- Submissions and their statuses are stored in MySQL, not localStorage.
- Teachers can download submitted files and approve or return them. A returned submission requires a remark.
- Students see their own records and teacher remarks; other students' records are not shown to them.
- File downloads require login and are restricted to the owning student or a teacher.

IMPORTANT
- This is a functional local development version. To use it across the internet, deploy it to a PHP/MySQL web host with HTTPS, backups, appropriate file permissions, email recovery, and a real admin provisioning process. A localhost website is not automatically public on the internet.
- Before public deployment, review security, configure HTTPS and secure session cookies, add rate limiting/email verification/password reset, and set upload limits in php.ini (upload_max_filesize and post_max_size should be at least 10M/12M).
- Do not use public teacher signup; create teacher accounts through an authorized administrator.

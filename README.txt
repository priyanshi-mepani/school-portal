=========================================================
STUDENT PORTAL & COURSE REGISTRATION SYSTEM
=========================================================

## OVERVIEW
This is a fully functional Student Portal built with PHP, MySQL, JavaScript, and HTML. 
It features secure user registration (password hashing), dynamic role-based dashboards (Admin vs. Student), live status checking, and automated email confirmations upon course enrollment.

## 1. BASIC SETUP & DATABASE (AUTO-INSTALL)
You do NOT need to manually import a database (.sql) file! 

1. Place the project folder into your XAMPP `htdocs` directory.
2. Open the XAMPP Control Panel and start Apache and MySQL.
3. Open your browser and navigate to: http://localhost/YOUR_FOLDER_NAME/home.html
4. The system features an auto-building database. The moment you attempt to register a new user, `db.php` will automatically create `school_db` and the `users` table if they do not exist.

=========================================================
## 2. LIVE EMAIL CONFIGURATION (IMPORTANT FOR GRADING)
=========================================================
This application is programmed to send real confirmation emails to the Student and an alert email to the Admin. 

Because XAMPP does not have a native mail server, you must configure your local `sendmail` and `php.ini` files with a Google App Password to test the live email functionality. 

If you just want to review the PHP mail logic, please see `enroll.php`. If you want to test the live emails on your local machine, please follow these steps:

### STEP A: Generate a Google App Password
1. Go to your Google Account -> Security -> 2-Step Verification.
2. Scroll to the bottom and click "App passwords".
3. Create a new app password (e.g., "XAMPP") and copy the 16-letter code.

### STEP B: Configure sendmail.ini
1. Navigate to your XAMPP sendmail folder (usually `C:\xampp\sendmail\`).
2. Open `sendmail.ini` and replace its contents with this block:

[sendmail]
smtp_server=smtp.gmail.com
smtp_port=465
smtp_ssl=ssl
error_logfile=error.log
debug_logfile=debug.log
auth_username=YOUR_TESTING_GMAIL@gmail.com
auth_password=YOUR_16_LETTER_APP_PASSWORD
force_sender=YOUR_TESTING_GMAIL@gmail.com

### STEP C: Configure php.ini
1. Open your XAMPP Control Panel -> Apache Config -> `php.ini`.
2. Find the `[mail function]` section.
3. Comment out the default Windows SMTP and enable the sendmail path. It should look like this (adjust the drive letter if your XAMPP is installed elsewhere):

[mail function]
;SMTP=localhost
;smtp_port=25
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

### STEP D: Update `enroll.php` Headers
1. Open `enroll.php` in the project folder.
2. Go to line 51 and change the `$myRealEmail` variable to match the testing Gmail address you put in `sendmail.ini`. This ensures Google does not flag the outgoing emails as spam.

### STEP E: Restart & Test
1. Restart Apache in your XAMPP Control Panel.
2. Register a user with the role of "Admin". (The system dynamically fetches the admin's email from the database to send the admin alerts).
3. Register a second user with the role of "Student" using a real email address you have access to.
4. Log in as the Student and enroll in a course. 
5. Check your inboxes for the formatted confirmation emails!

=========================================================
## FEATURES TO TEST
=========================================================
- Register as an Admin, log in, and view the Admin Dashboard (Dashboard routes dynamically based on role).
- Register as a Student, log in, and enroll in a course.
- Attempt to enroll in the same course twice (System prevents duplicates).
- Check the "Courses" page after enrolling (Buttons dynamically turn green and disable if already enrolled).
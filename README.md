# School Portal System

A web-based School Portal developed as part of my BTEC IT coursework. The project provides student registration, login, course enrollment, and an administrator dashboard for viewing student registrations.

## Features

- **User Registration:** Create an account with a role, email, and password.
- **Secure Login:** Password hashing and verification using PHP.
- **Course Enrollment:** Allow logged-in students to enroll in courses and select units.
- **Admin Dashboard:** View student course registrations and selected units.
- **Session Management:** Protect pages based on login status and user role.
- **Email Notifications:** Includes an attempt to send enrollment confirmation emails to students and administrators.

## Technologies Used

- PHP
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript
- XAMPP
- phpMyAdmin

## Project Structure

The project includes PHP files for database setup, registration, login, enrollment, dashboard access, and logout, along with the SQL database file and website interface files.

## Running the Project Locally

1. Install XAMPP with Apache and MySQL/MariaDB.
2. Place the project folder inside the XAMPP `htdocs` directory.
3. Start Apache and MySQL from the XAMPP Control Panel.
4. Import the provided SQL file into phpMyAdmin, or use the database setup included in the project.
5. Configure the database connection in `db.php` if necessary.
6. Open the project through your local server in a browser.

**Note:** This project is intended as a learning and portfolio demonstration. Local configuration may be required, and email notifications depend on a correctly configured mail service.

## Learning Outcomes

Through this project, I practised:

- Connecting PHP applications to a MySQL database.
- Implementing user registration and login.
- Using password hashing and prepared SQL statements.
- Managing sessions and role-based page access.
- Building web interfaces with HTML and CSS.
- Handling course enrollment data.

## Author

**Priyanshi Mepani**

BTEC IT Coursework Project

GitHub: [priyanshi-mepani](https://github.com/priyanshi-mepani)

<?php
session_start();
require 'db.php';

// 1. SECURITY: Kick out anyone not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 2. SECURITY: Route Admins back to their correct dashboard
if ($_SESSION['role'] === 'admin') {
    header("Location: dashboard.php");
    exit();
}

// 3. Fetch this specific student's course from the database
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT course FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$course = "Not assigned";
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $course = $user['course'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal Dashboard</title>
    <style>
        body { 
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f6f9; 
        }

        /* NAVBAR STYLES ADDED HERE */
        nav {
            background: #2c3e50;
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        nav h2 { margin: 0; }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
        }
        nav a:hover { text-decoration: underline; }

        /* DASHBOARD STYLES */
        .dashboard-wrapper {
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
        }
        .container { 
            background: white; 
            padding: 3rem; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            text-align: center; 
            width: 100%; 
            max-width: 500px; 
            border-top: 5px solid #16a34a; 
        }
        h1 { color: #333; margin-bottom: 0.5rem; }
        .course-box { 
            background: #e0e7ff; 
            color: #4338ca; 
            padding: 1rem; 
            border-radius: 8px; 
            margin: 1.5rem 0; 
            font-size: 1.2rem; 
            font-weight: bold; 
        }
        .btn-logout { 
            display: inline-block; 
            margin-top: 1rem; 
            padding: 10px 20px; 
            background: #dc2626; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: 500; 
        }
    </style>
</head>
<body>

    <nav>
        <h2>Student Portal</h2>
        <div>
            <a href="home.html">Home</a>
            <a href="courses.html">Courses</a>
            <a href="apply.html">How to Apply</a>
            <a href="contact.html">Contact Us</a>
            <a href="logout.php" style="background: #dc2626; color: white; padding: 5px 15px; border-radius: 5px; margin-left: 20px;">Logout</a>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="container">
            <h1>Welcome, Student!</h1>
            <p>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong></p>
            
            <div class="course-box">
                Registered Course:<br>
                <?php echo htmlspecialchars($course); ?>
            </div>

            <p>Your registration is complete. Check back later for your schedule.</p>

        </div>
    </div>

</body>
</html>
<?php
session_start();
require 'db.php'; // We need the database connection to fetch the students

// 1. SECURITY: Kick out anyone not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 2. SECURITY: Kick out students (Only Admins allowed here)
if ($_SESSION['role'] !== 'admin') {
    die("Access Denied: You must be an administrator to view this page. <a href='logout.php'>Logout</a>");
}

// 3. UPDATED QUERY: Added 'enrolled_units' to the SELECT statement
$query = "SELECT email, course, enrolled_units FROM users WHERE role = 'student'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Registrations</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; padding: 2rem; }
        .container { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #667eea; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .btn-logout { display: inline-block; margin-top: 2rem; padding: 10px 20px; background: #dc2626; color: white; text-decoration: none; border-radius: 8px; }
        /* Style for the units list */
        .units-text { font-size: 0.9rem; color: #555; font-style: italic; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong></p>
        
        <h2>Student Course Registrations</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Student Email</th>
                    <th>Registered Course</th>
                    <th>Selected Units</th> </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                        
                        // NEW COLUMN DATA
                        // We check if it's empty so it doesn't look blank
                        $units = !empty($row['enrolled_units']) ? $row['enrolled_units'] : "No units selected";
                        echo "<td class='units-text'>" . htmlspecialchars($units) . "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>No students registered yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

</body>
</html>
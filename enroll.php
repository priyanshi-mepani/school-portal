<?php
session_start();
header("Content-Type: application/json");
require 'db.php';

// 1. SECURITY: Check if student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(401);
    echo json_encode(["error" => "You must be logged in as a student to enroll."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->course)) {
    $newCourse = $data->course;
    
    // --- HANDLE UNITS ---
    $unitsArray = !empty($data->units) ? $data->units : [];
    $newUnitsString = implode(", ", $unitsArray); 
    
    $userId = $_SESSION['user_id'];
    $studentEmail = $_SESSION['email']; // Grabs the email used at login

    // 2. Fetch current data
    $stmt = $conn->prepare("SELECT course, enrolled_units FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $currentCourses = $user['course'];
    $currentUnits = $user['enrolled_units'];
    $stmt->close();

    // 3. Append logic
    if ($currentCourses === 'Not Enrolled' || empty($currentCourses)) {
        $updatedCourses = $newCourse;
        $updatedUnits = $newUnitsString;
    } else {
        $courseArray = array_map('trim', explode(',', $currentCourses));
        if (in_array($newCourse, $courseArray)) {
            http_response_code(400);
            echo json_encode(["error" => "You are already enrolled in this course."]);
            exit();
        }
        $updatedCourses = $currentCourses . ", " . $newCourse;
        $updatedUnits = (empty($currentUnits)) ? $newUnitsString : $currentUnits . " | " . $newUnitsString;
    }

    // 4. Update Database
    $updateStmt = $conn->prepare("UPDATE users SET course = ?, enrolled_units = ? WHERE id = ?");
    $updateStmt->bind_param("ssi", $updatedCourses, $updatedUnits, $userId);

    if ($updateStmt->execute()) {
        // --- PROFESSIONAL EMAIL LOGIC ---
        $adminEmail = "priyashi.mepani@gmail.com"; // Your fixed admin email
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Student Portal <" . $adminEmail . ">" . "\r\n";

        // HTML Body for the email
        $emailBody = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='background: #667eea; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h2>Registration Details</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>A new course registration has been processed:</p>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #eee;'><strong>Student Email:</strong></td>
                        <td style='padding: 10px; border: 1px solid #eee;'>$studentEmail</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #eee;'><strong>New Course:</strong></td>
                        <td style='padding: 10px; border: 1px solid #eee;'>$newCourse</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #eee;'><strong>Selected Units:</strong></td>
                        <td style='padding: 10px; border: 1px solid #eee; color: #4338ca;'>$newUnitsString</td>
                    </tr>
                </table>
                <p style='margin-top:20px;'><strong>Updated Student Course List:</strong><br>$updatedCourses</p>
                <p>Best regards,<br>Student Portal System</p>
            </div>
        </body>
        </html>";

        // Send to Student
        @mail($studentEmail, "Enrollment Confirmation - $newCourse", $emailBody, $headers);

        // Send to Admin (Directly using your email for reliability)
        @mail($adminEmail, "ADMIN ALERT: New Enrollment from $studentEmail", $emailBody, $headers);

        http_response_code(200);
        echo json_encode(["message" => "Successfully enrolled! Confirmation sent to student and admin."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Database update failed."]);
    }
    $updateStmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "No course data received."]);
}
$conn->close();
?>
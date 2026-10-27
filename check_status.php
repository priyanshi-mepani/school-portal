<?php
session_start();
header("Content-Type: application/json");
require 'db.php';

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student') {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT course FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Send back the courses (e.g., "Web Development, Data Science")
        echo json_encode(["loggedIn" => true, "courses" => $user['course']]);
        exit();
    }
}
echo json_encode(["loggedIn" => false]);
?>
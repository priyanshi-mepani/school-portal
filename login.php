<?php
session_start();
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->role) && !empty($data->email) && !empty($data->password)) {
    $role = $data->role;
    $email = $data->email;
    $password = $data->password;

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role;

            http_response_code(200);
            echo json_encode(["message" => "Login successful!"]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Invalid password."]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found."]);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Please fill in all fields."]);
}
$conn->close();
?>
<?php
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->role) && !empty($data->email) && !empty($data->password)) {
    $role = $data->role;
    $email = $data->email;
    $password = password_hash($data->password, PASSWORD_DEFAULT);
    $course = 'Not Enrolled';

    $stmt = $conn->prepare("INSERT INTO users (role, email, course, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $role, $email, $course, $password);

    try {
        $stmt->execute();
        http_response_code(201);
        echo json_encode(["message" => "Account created successfully!"]);
    } catch (mysqli_sql_exception $e) {
        // Error code 1062 means "Duplicate Entry" in MySQL
        if ($e->getCode() == 1062) {
            http_response_code(400);
            echo json_encode(["error" => "Account already exists with this email."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Database error occurred."]);
        }
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Please fill in all required fields."]);
}
$conn->close();
?>
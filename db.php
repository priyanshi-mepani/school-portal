<?php
$host = 'localhost';
$user = 'root';
$pass = ''; 
$dbname = 'school_db';

// 1. Connect to the XAMPP MySQL server (Notice we don't connect to the database yet)
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    // If this fails, XAMPP MySQL probably isn't turned on
    die(json_encode(["error" => "Server connection failed. Is MySQL running in XAMPP?"]));
}

// 2. Automatically create the database if the teacher doesn't have it
$sql_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql_db)) {
    die(json_encode(["error" => "Failed to create database automatically."]));
}

// 3. Now actually select our newly created database
$conn->select_db($dbname);

// 4. Automatically create the 'users' table if it doesn't exist
$sql_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(100),
    password VARCHAR(255) NOT NULL
)";

if (!$conn->query($sql_table)) {
    die(json_encode(["error" => "Failed to create tables automatically."]));
}

// If we make it to the end of this file, the database is perfectly set up and connected!
?>
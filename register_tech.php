<?php
$host = "localhost";
$username = "root"; 
$password = "";   
$database = "event";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$class = $_POST['class'] ?? '';
$tech = $_POST['tech'] ?? '';

if (empty($name) || empty($email) || empty($class) || empty($tech)) {
    echo "Please fill all fields.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO tech_registrations (name, email, class, tech) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $class, $tech);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

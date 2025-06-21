<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "event"; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $class = trim($_POST['class']);
    $sport = trim($_POST['sport']);

    if (empty($name) || empty($email) || empty($class) || empty($sport)) {
        http_response_code(400);
        echo "All fields are required.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO sport_registrations (name, email, class_name, sport) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $class, $sport);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Failed to register.";
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo "Invalid request method.";
}

$conn->close();
?>

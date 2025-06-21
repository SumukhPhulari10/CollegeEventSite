<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "event"; // ✅ Replace with your database name

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $class = trim($_POST['class']);
    $eventType = trim($_POST['eventType']);

    if (empty($name) || empty($email) || empty($class) || empty($eventType)) {
        http_response_code(400);
        echo "All fields are required.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO cultural_event_registrations (name, email, class_name, event_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $class, $eventType);

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

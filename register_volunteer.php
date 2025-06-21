<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "event";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$class = isset($_POST['class']) ? $conn->real_escape_string($_POST['class']) : '';
$volunteer = isset($_POST['volunteer']) ? $conn->real_escape_string($_POST['volunteer']) : '';

if (empty($name) || empty($email) || empty($class) || empty($volunteer)) {
    echo "Please fill in all fields.";
    exit;
}

$sql = "INSERT INTO volunteer_registrations (name, email, class, volunteer_role)
        VALUES ('$name', '$email', '$class', '$volunteer')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>


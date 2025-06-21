<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('Email already registered.'); window.history.back();</script>";
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo "<script>alert('Registration Successful! Please Sign In.'); window.location.href='sign_in.html';</script>";
} else {
    echo "<script>alert('Registration Failed!'); window.history.back();</script>";
}

$conn->close();
?>

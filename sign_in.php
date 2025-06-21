<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_db";
$conn = new mysqli("localhost", $user, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo "error not connect to server";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "error";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    if (!$stmt) {
        echo "error";
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            echo "success email and password is correct";
        } else {
            echo "error email or password is wrong"; 
        }
    } else {
        echo "error"; 
    }

    $stmt->close();
} else {
    echo "error"; 
}

$conn->close();
?>

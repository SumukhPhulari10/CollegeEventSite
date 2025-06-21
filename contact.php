<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Show errors for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // DB connection
    $conn = new mysqli("localhost", "root", "", "event_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['Message']);

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // JS Alert and redirect back to index.html
        echo "<script>
                alert('Thank you $name, your message was sent successfully!');
                window.location.href = 'index.html#contact';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'index.html#contact';
              </script>";
    }

    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: index.html");
    exit();
}
?>

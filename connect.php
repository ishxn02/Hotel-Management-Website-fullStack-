<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    // Database Connection
    $conn = new mysqli('localhost', 'root', '', 'user');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO guest (firstName, lastName, gender, email, phoneNumber) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }

    // Bind parameters and execute query
    $stmt->bind_param("ssssi", $firstName, $lastName, $gender, $email, $phoneNumber);
    $execval = $stmt->execute();
    if (!$execval) {
        die("Error in executing query: " . $stmt->error);
    }

    echo "Registration successful";
    
    // Save guest ID in session
    $_SESSION['current_user'] = $stmt->insert_id;

    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit();
} else {
    echo "Invalid request method";
}
?>

<?php
session_start();

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'user');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['current_user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve user details from the database
$userID = $_SESSION['current_user'];
$stmt = $conn->prepare("SELECT firstName FROM guest WHERE id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['firstName'];
} else {
    $firstName = "Guest"; // Default value if user not found
}

$stmt->close();

// Retrieve booking details from session
if (isset($_SESSION['selected_hotel']) && isset($_SESSION['room_type']) && isset($_SESSION['check_in']) && isset($_SESSION['check_out'])) {
    $hotel = $_SESSION['selected_hotel'];
    $room = $_SESSION['room_type'];
    $checkIn = $_SESSION['check_in'];
    $checkOut = $_SESSION['check_out'];

    // Calculate number of days booked
    $checkInDate = new DateTime($checkIn);
    $checkOutDate = new DateTime($checkOut);
    $interval = $checkInDate->diff($checkOutDate);
    $numDays = $interval->days;

    // Retrieve room price from the database
    $stmtPrice = $conn->prepare("SELECT price FROM room_type WHERE room_type = ?");
    $stmtPrice->bind_param("s", $room);
    $stmtPrice->execute();
    $resultPrice = $stmtPrice->get_result();

    if ($resultPrice->num_rows > 0) {
        $rowPrice = $resultPrice->fetch_assoc();
        $pricePerNight = $rowPrice['price'];
        $totalPrice = $pricePerNight * $numDays;
    } else {
        $totalPrice = 0; 
    }

    $stmtPrice->close();

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="confirmation.css">
</head>
<body>
    <main class="container">
        <h2>Booking Confirmation</h2>

        <div class="confirmation-details">
            <h3>Thank You for Your Booking, ' . $firstName . '!</h3>

            <!-- Booking details -->
            <p>You have successfully booked:</p>
            <ul>
                <li><strong>Hotel:</strong> ' . $hotel . '</li>
                <li><strong>Room Type:</strong> ' . $room . '</li>
                <li><strong>Check-In Date:</strong> ' . $checkIn . '</li>
                <li><strong>Check-Out Date:</strong> ' . $checkOut . '</li>
                <li><strong>Total Price:</strong> AED ' . $totalPrice . '</li>
            </ul>

            <p>We look forward to welcoming you. If you have any questions or need assistance, please contact our customer service team.</p>

            <div class="thank-you-message">
                <p>Thank you for booking using our site. Have a wonderful stay!</p>
            </div>
        </div>

        <!-- Optionally, provide a button to return to the home page or make another booking -->
        <div class="button-container">
            <button onclick="location.href=\'index.html\'">Return to Home</button>
        </div>
    </main>
</body>
</html>';
} else {
    // If booking details are not set in session, redirect to the home page or another appropriate page
    header("Location: index.html");
    exit();
}

// Close database connection
$conn->close();
?>

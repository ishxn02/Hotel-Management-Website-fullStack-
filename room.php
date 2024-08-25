<?php
session_start();

if (!isset($_SESSION['current_user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'user');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

// Handle room booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room'])) {
    $roomType = $_POST['room'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $hotel = $_SESSION['selected_hotel'];


    $_SESSION['room_type'] = $roomType;
    $_SESSION['check_in'] =$checkIn;
    $_SESSION['check_out'] = $checkOut;

    // Prepare and execute SQL statement to insert reservation
    $stmt = $conn->prepare("INSERT INTO reservations (guest_id, hotel, room_type, check_in_date, check_out_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $userID, $hotel, $roomType, $checkIn, $checkOut);
    $stmt->execute();

    $stmt->close();

    header("Location: confirmation.php");
    exit();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="room.css">
    <title>Available Rooms</title>
</head>
<body>
    <main class="container">
        <h2>Select a Room</h2>

        <!-- Available Rooms -->
        <form action="room.php" method="post" class="room-form">
            <div class="room-list">
                <!-- Room 1 -->
                <label class="room-card" for="room1">
                    <input type="radio" name="room" id="room1" value="Deluxe Room" required>
                    <img src="rooms/room1.jpg" alt="Deluxe Room" class="room-image">
                    <div class="room-details">
                        <h3>Deluxe Room</h3>
                        <p>Cost: AED 200/night</p>
                        <p>Bed: King-size</p>
                    </div>
                </label>

                <!-- Room 2 -->
                <label class="room-card" for="room2">
                    <input type="radio" name="room" id="room2" value="Suite Room" required>
                    <img src="rooms/room2.jpg" alt="Suite Room" class="room-image">
                    <div class="room-details">
                        <h3>Suite Room</h3>
                        <p>Cost: AED 300/night</p>
                        <p>Bed: Queen-size</p>
                    </div>
                </label>

                <!-- Room 3 -->
                <label class="room-card" for="room3">
                    <input type="radio" name="room" id="room3" value="Standard Room" required>
                    <img src="rooms/room3.jpg" alt="Standard Room" class="room-image">
                    <div class="room-details">
                        <h3>Standard Room</h3>
                        <p>Cost: AED 100/night</p>
                        <p>Bed: Single</p>
                    </div>
                </label>
            </div>

            <!-- Date Fields -->
            <div class="date-fields">
                <label class="input-field" for="check-in">
                    <span>Check-In</span>
                    <input type="date" name="check_in" id="check-in" required>
                </label>

                <label class="input-field" for="check-out">
                    <span>Check-Out</span>
                    <input type="date" name="check_out" id="check-out" required>
                </label>
            </div>

            <!-- Book Now Button -->
            <input type="submit" value="Book Now" class="book-now-button">
        </form>
    </main>
</body>
</html>

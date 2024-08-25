<?php
session_start();

// Check if user is logged in
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
    // Fetch the first name
    $row = $result->fetch_assoc();
    $firstName = $row['firstName'];
} else {
    $firstName = "Guest"; // Default value if user not found
}

// Close statement
$stmt->close();
$conn->close();


// Store the selected hotel in session if it's provided in the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedHotel'])) {
    $_SESSION['selected_hotel'] = $_POST['selectedHotel'];
    header("Location: room.php"); // Redirect to room.php
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Hotel</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <main class="container">

        <div class="welcome-message">
            Welcome, <?php echo $firstName; ?>!
        </div>

        <h2>Select a Hotel</h2>
            <div class="hotel-list">
            <!-- Hotel 1 -->
            <form action="home.php" method="post">
                <div class="hotel-card">
                <input type="radio" id="hotel1" name="selectedHotel" value="Hotel Burj Al Arab" hidden>
                <label for="hotel1">
                    <img src="hotel1.jpg" alt="Hotel 1" class="hotel-image">
                    <div class="hotel-details">
                        <h3>Hotel Burj Al Arab</h3>
                        <p>Location: Downtown City</p>
                        <p>Starting at $120/night</p>
                    </div>
                </label>
                </div>
            </form>
            <!-- Hotel 2 -->
            <form action="home.php" method="post">
                <div class="hotel-card">
                <input type="radio" id="hotel2" name="selectedHotel" value="Hotel Atlantis" hidden>
                <label for="hotel2">
                    <img src="hotel2.jpg" alt="Hotel 2" class="hotel-image">
                    <div class="hotel-details">
                        <h3>Hotel Atlantis</h3>
                        <p>Location: Beachfront</p>
                        <p>Starting at $150/night</p>
                    </div>
                </label>
                </div>
            </form>
            <!-- Hotel 3 -->
            <form action="home.php" method="post">
                <div class="hotel-card">
                <input type="radio" id="hotel3" name="selectedHotel" value="Emirates Palace" hidden>
                <label for="hotel3">
                    <img src="hotel3.jpg" alt="Hotel 3" class="hotel-image">
                    <div class="hotel-details">
                        <h3>Emirates Palace</h3>
                        <p>Location: Hill Station</p>
                        <p>Starting at $100/night</p>
                    </div>
                </label>
                </div>
            </form>
            <!-- Hotel 4 -->
            <form action="home.php" method="post">
                <div class="hotel-card">
                <input type="radio" id="hotel4" name="selectedHotel" value="Hotel Hilton" hidden>
                <label for="hotel4">
                    <img src="hotel4.jpg" alt="Hotel 4" class="hotel-image">
                    <div class="hotel-details">
                        <h3>Hotel Hilton</h3>
                        <p>Location: City Center</p>
                        <p>Starting at $130/night</p>
                    </div>
                </label>
                </div>
            </form>
            <!-- Hotel 5 -->
            <form action="home.php" method="post">
                <div class="hotel-card">
                <input type="radio" id="hotel5" name="selectedHotel" value="Atlantis The Royal" hidden>
                <label for="hotel5">
                    <img src="hotel5.jpg" alt="Hotel 5" class="hotel-image">
                    <div class="hotel-details">
                        <h3>Atlantis The Royal</h3>
                        <p>Location: Desert</p>
                        <p>Starting at $110/night</p>
                    </div>
                </label>
                </div>
            </form>
            </div>
            <!--<input type = "submit" value = "Book Selected Hotel">-->
    </main>
</body>
</html>

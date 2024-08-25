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
$conn->close();


// Store the selected hotel in session if it's provided in the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedHotel'])) {
    $_SESSION['selected_hotel'] = $_POST['selectedHotel'];
    header("Location: room.php"); 
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

            <div class="hotel-card" onclick="submitForm('Hotel Burj Al Arab')">
                <input type="hidden" name="selectedHotel" value="Hotel Burj Al Arab">
                <img src="hotels/hotel1.jpg" alt="Hotel 1" class="hotel-image">
                <div class="hotel-details">
                    <h3>Hotel Burj Al Arab</h3>
                    <p>Location: Downtown City</p>
                    <p>Starting at AED 120/night</p>
                </div>
            </div>
            <!-- Hotel 2 -->
            <div class="hotel-card" onclick="submitForm('Hotel Atlantis')">
                <input type="hidden" name="selectedHotel" value="Hotel Atlantis">
                <img src="hotels/hotel2.jpg" alt="Hotel 2" class="hotel-image">
                <div class="hotel-details">
                    <h3>Hotel Atlantis</h3>
                    <p>Location: Beachfront</p>
                    <p>Starting at AED 150/night</p>
                </div> 
            </div>
            <!-- Hotel 3 -->
            <div class="hotel-card" onclick="submitForm('Emirates Palace')">
                <input type="hidden" name="selectedHotel" value="Emirates Palace">
                <img src="hotels/hotel3.jpg" alt="Hotel 3" class="hotel-image">
                <div class="hotel-details">
                    <h3>Emirates Palace</h3>
                    <p>Location: Hill Station</p>
                    <p>Starting at AED 100/night</p>
                </div>
            </div>
            <!-- Hotel 4 -->
            <div class="hotel-card" onclick="submitForm('Hotel Hilton')">
                <input type="hidden" name="selectedHotel" value="Hotel Hilton">
                <img src="hotels/hotel4.jpg" alt="Hotel 4" class="hotel-image">
                <div class="hotel-details">
                    <h3>Hotel Hilton</h3>
                    <p>Location: City Center</p>
                    <p>Starting at AED 130/night</p>
                </div>
            </div>
            <!-- Hotel 5 -->
            <div class="hotel-card" onclick="submitForm('Atlantis The Royal')">
                <input type="hidden" name="selectedHotel" value="Atlantis The Royal">
                <img src="hotels/hotel5.jpg" alt="Hotel 5" class="hotel-image">
                <div class="hotel-details">
                    <h3>Atlantis The Royal</h3>
                    <p>Location: Desert</p>
                    <p>Starting at AED 110/night</p>
                </div>
            </div>
        </div>
        <form id="hotelForm" action="home.php" method="post">
            <input type="hidden" id="selectedHotelInput" name="selectedHotel" value="">
        </form>

        <script>
            function submitForm(hotelName) {
                document.getElementById('selectedHotelInput').value = hotelName;
                document.getElementById('hotelForm').submit();
            }
        </script>

    </main>
</body>
</html>

<!--------------------------------------------------------------------------------------------------------------------------------->
<?php
require 'auth.php';  // Ensure session is active
require './config/db.php'; // Include your database connection

// Fetch the user booking details from the database
$email = $_SESSION['email'];

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    // Retrieve details from the database
    $name = $user['name'];
    $email = $user['email'];
    $phone = $user['phone'];
    $date = $user['booking_date'];
    $bookingIdx = $user['booking_id'];  // Retrieve `booking_id` from the database
    $timeSlot = $user['slot'];
} else {
    echo "No booking found for this user.";
    exit();
}
?>

<?php
session_destroy();
?>
<!--------------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed Successfully</title>
    <link href="./css/booking.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://testbook.com/assets/img/brand/logo-32x32.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="thank-you-container">
        <img src="./img/green-tick.svg" alt="Success">
        <h1>Seat Booked Successfully</h1>
        <div class="thank-you-details">
            <p><span>Your Name:</span> <?php echo htmlspecialchars($name); ?></p>
            <p><span>Your Booking ID:</span> <?php echo htmlspecialchars($bookingIdx); ?></p>
            <p><span>Your Selected Time Slot:</span> <?php echo htmlspecialchars($timeSlot); ?></p>
            <p><span>Your Email:</span> <?php echo htmlspecialchars($email); ?></p>
            <p><span>Your Phone:</span> <?php echo htmlspecialchars($phone); ?></p>
            <p><span>Booking Date:</span> <?php echo htmlspecialchars($date); ?></p>
        </div>
        <a href="https://testbook.com/jee-main/test-series" target="_blank">Explore Full Test Series</a>
    </div>
<!--------------------------------------------------------------------------------------------------------------------------------->
</body>
</html>

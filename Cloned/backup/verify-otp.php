<!--------------------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
require './config/db.php'; // Database connection

$otp_error = ''; // Initialize error message

// Check if the session email is set
if (!isset($_SESSION['email'])) {
$otp_error = "Your session has expired. Please start the process again.";
} else {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Check if the 'otp' field is set in POST request
if (isset($_POST['otp'])) {
$otp_input = htmlspecialchars($_POST['otp']);
$email = $_SESSION['email'];

// Check if OTP is correct
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE email = ? AND otp = ?");
$stmt->execute([$email, $otp_input]);
$user = $stmt->fetch();

if ($user) {
    // OTP is correct, mark the user as verified
    $stmt = $pdo->prepare("UPDATE bookings SET is_verified = 1 WHERE email = ?");
    $stmt->execute([$email]);

    // Redirect to booking-confirmed.php
    header("Location: booking-confirmed.php");
    exit();
} else {
    $otp_error = "Invalid OTP. Please try again.";
}
} else {
$otp_error = "Please enter the OTP.";
}
}
}
?>

<!--------------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your OTP</title>
    <link href="./css/verify-otp.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://testbook.com/assets/img/brand/logo-32x32.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<!--------------------------------------------------------------------------------------------------------------------------------->
<body>
    <div class="thank-you-container">
        <img src="./img/password.png" alt="OTP Verification">
        <h3>Verify Email OTP - To confirm your booking
        </h3>
        <div class="thank-you-details">

            <!-- Display Error Message if OTP is Invalid -->
            <?php if (!empty($otp_error)): ?>
            <div class="alert" role="alert">
                <?php echo $otp_error; ?>
            </div>
            <?php endif; ?>

            <!-- OTP Form -->
            <form action="verify-otp.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-primary">Verify OTP</button>
            </form>
        </div>
        <a href="./index.php">Go Back to Home</a>
    </div>
<!--------------------------------------------------------------------------------------------------------------------------------->
</body>
</html>

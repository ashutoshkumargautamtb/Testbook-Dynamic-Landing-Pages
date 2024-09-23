<!------------------------------------------------------------------------------------------------------------>

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

<!------------------------------------------------------------------------------------------------------------>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed Successfully</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" href="https://testbook.com/assets/img/brand/logo-32x32.png" sizes="32x32">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    
    <!-- Other CSS Files -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        /* Sticky navbar */
        .navbar {
            width: 100%;
            padding: 15px 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar img {
            max-width: 150px;
        }

        /* Add margin to the content to avoid overlap with the sticky navbar */
        .thank-you-container {
            background-color: #fff;
            max-width: 500px; /* Adjust width for balance */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 100px auto 0; /* Adjusted top margin to account for the sticky navbar */
        }

        .thank-you-container img {
            width: 80px;
            margin-bottom: 20px;
        }

        .thank-you-container h1 {
            font-size: 2rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .thank-you-details p {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #333;
        }

        .thank-you-details p span {
            font-weight: 600;
            color: #000;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .thank-you-container {
                padding: 25px;
                max-width: 90%; /* Adjust for mobile */
                margin-top: 120px; /* Extra margin to account for smaller navbar on mobile */
            }

            .thank-you-container img {
                width: 60px;
            }

            .thank-you-container h1 {
                font-size: 1.7rem;
            }

            a {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar with centered logo, sticky at the top -->
    <nav class="navbar">
        <img alt="logo" src="assets/img/logo.png">
    </nav>

    <!-- Success Message Container -->
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

    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

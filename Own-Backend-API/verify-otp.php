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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP</title>

  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="shortcut icon" href="https://testbook.com/assets/img/brand/logo-32x32.png" sizes="32x32">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- CSS only -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
  <!-- fancybox -->
  <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <!-- style -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- responsive -->
  <link rel="stylesheet" href="assets/css/responsive.css">
  <!-- color -->
  <link rel="stylesheet" href="assets/css/color.css">
  <link rel="stylesheet" href="custom-css/custom.css">

  <style>
    /* Centering the form */
    .thank-you-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f7f7f7;
    }

    .card {
      width: 100%;
      max-width: 500px; /* Make the form wider */
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .card img {
      max-width: 100px;
      margin: 0 auto 20px auto;
      display: block;
    }

    .card h3 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 1.5rem;
    }

    .card p {
      text-align: center;
      color: #6c757d;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #4CAF50; /* Customize the button color */
      border: none;
      width: 100%;
      padding: 12px;
      font-size: 1.1rem;
    }

    .btn-primary:hover {
      background-color: #45a049;
    }

    .form-control {
      border-radius: 5px;
      height: 45px;
      font-size: 1rem;
    }

    .alert {
      margin-bottom: 20px;
      color: #dc3545;
      text-align: center;
    }

    .thank-you-container a {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #007bff;
      font-size: 1rem;
    }

    .thank-you-container a:hover {
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .card {
        padding: 20px;
      }

      .card img {
        max-width: 80px;
      }
    }
  </style>
</head>

<body>
  <!-- header -->
  <header id="stickyHeader">
    <div class="container">
      <div class="top-bar">
        <img alt="logo" src="assets/img/logo.png">
      </div>
    </div>
  </header>

  <div class="thank-you-container">
    <div class="card">
      <img src="./img/password.png" alt="OTP Verification">
      <h3>Verify Email OTP</h3>
      <p>To confirm your booking</p>

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
        <button type="submit" class="btn btn-primary btn-block mt-3">Verify OTP</button>
      </form>

      <a href="./index.php">Go Back to Home</a>
    </div>
  </div>

  <!-- jQuery -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap Js -->
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <!-- fancybox -->
  <script src="assets/js/jquery.fancybox.min.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>

<!------------------------------------------------------------------------------------------------------------>

<?php
// Start session
session_start();

// Include database connection
include('./config/db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $slot = htmlspecialchars($_POST['slot']);  // Booking slot
    $date = date("Y-m-d"); // Use current date as booking date
    
    // Generate a 6-digit random number for the booking ID (e.g., IITJEE123456)
    $randomNumber = rand(100000, 999999); 
    $bookingId = "IITJEE" . $randomNumber;

    // Generate a random OTP (6-digit number)
    $otp = rand(100000, 999999);

    try {
        // Start a database transaction
        $pdo->beginTransaction();

        // Insert the form data into the database
        $stmt = $pdo->prepare("INSERT INTO bookings (name, email, phone, booking_date, otp, slot, booking_id, is_verified) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        
        // Execute the query with the user input
        if (!$stmt->execute([$name, $email, $phone, $date, $otp, $slot, $bookingId])) {
            $pdo->rollBack();
            die("Error inserting data into the database.");
        }

        // Commit the transaction to save the data
        $pdo->commit();

        // Store email and OTP in session for later use in OTP verification
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp;

        // Send OTP via SMS using MSG91 Flow API

        // Initialize cURL session
        $curl = curl_init();

        // Set up the parameters for the API request
        $authkey = "362200A3B0DKIEL66dacef9P1";           // Your MSG91 Auth key
        $template_id = "66d9a2d0d6fc054d9457e433";     // Your MSG91 Flow Template ID
        $mobile = "91" . $phone;                  // Recipient's mobile number with country code
        $otp_expiry = 5;                          // OTP expiry in minutes (optional)
        $var2_2 = "confirm seat";
        $var3_3 = "All India IIT JEE Test by";


        // Prepare the data to be sent via the API
        $data = [
            'flow_id' => $template_id,
            'sender' => 'TESTBK',  // Replace with your approved sender ID
            'mobiles' => $mobile,
            'var1' => $otp, 
            'var2' => $var2_2,
            'var3' => $var3_3,         // Passing the OTP to the template variable
            'otp_expiry' => $otp_expiry
        ];

        // Set cURL options for the API request
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),   // Send data as JSON
            CURLOPT_HTTPHEADER => [
                "authkey: $authkey",                    // Set the Auth Key in the header
                "Content-Type: application/json"        // Set content type as JSON
            ],
        ]);

        // Execute the API call and get the response
        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Close the cURL session
        curl_close($curl);

        // Check for errors or success response
        if ($err) {
            die("cURL Error #:" . $err);
        } else {
            echo $response;  // Output the API response to check if the SMS was sent successfully
        }

        // Redirect to OTP verification page
        header("Location: verify-otp.php");
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        die("Database error: " . $e->getMessage());
    }
}
?>

<!------------------------------------------------------------------------------------------------------------>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All India IIT & JEE Test By Testbook.</title>
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
    <!-- header end -->
    <section class="hero-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="hero-text">
              <h2>Join the Ultimate All India IIT-JEE Test and Prove Your Potential!</h2>
              <p>Compete with the brightest minds across the country and test your preparation with the most comprehensive
                IIT-JEE mock test! <a href="https://testbook.com" target="_blank"><strong><u>Know more...</u></strong></a>
              </p>
              <div class="video">
                <div class="svg-icon">
                </div>
                <div class="custom-btn">
                </div>
              </div>
            </div>
          </div>
         
         
          <div class="col-lg-5">
         
          <form role="form" class="get-a-quote" id="contact-form" action="" method="post">
              <div>
               <center> <h4><strong>All India IIT & JEE Test</strong>
               </h4></center>
               <br>
                <div class="active-users">
                  <img src="./img/usersBubble.svg" alt="Active Users">
                  <span>100000+ Active Users</span>
                </div>
              </div>
              <br>
              <div class="group-img">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15.364 11.636C14.3837 10.6558 13.217 9.93013 11.9439 9.49085C13.3074 8.55179 14.2031 6.9802 14.2031 5.20312C14.2031 2.33413 11.869 0 9 0C6.131 0 3.79688 2.33413 3.79688 5.20312C3.79688 6.9802 4.69262 8.55179 6.05609 9.49085C4.78308 9.93013 3.61631 10.6558 2.63605 11.636C0.936176 13.3359 0 15.596 0 18H1.40625C1.40625 13.8128 4.81279 10.4062 9 10.4062C13.1872 10.4062 16.5938 13.8128 16.5938 18H18C18 15.596 17.0638 13.3359 15.364 11.636ZM9 9C6.90641 9 5.20312 7.29675 5.20312 5.20312C5.20312 3.1095 6.90641 1.40625 9 1.40625C11.0936 1.40625 12.7969 3.1095 12.7969 5.20312C12.7969 7.29675 11.0936 9 9 9Z"
                    fill="#555555"></path>
                </svg>
                <input type="text" name="name" placeholder="Your Full Name" required="">
              </div>
              <div class="group-img">
                <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15.8649 18H6.13513C2.58377 18 0.540527 15.9568 0.540527 12.4054V5.5946C0.540527 2.04324 2.58377 0 6.13513 0H15.8649C19.4162 0 21.4595 2.04324 21.4595 5.5946V12.4054C21.4595 15.9568 19.4162 18 15.8649 18ZM6.13513 1.45946C3.35242 1.45946 1.99999 2.81189 1.99999 5.5946V12.4054C1.99999 15.1881 3.35242 16.5406 6.13513 16.5406H15.8649C18.6476 16.5406 20 15.1881 20 12.4054V5.5946C20 2.81189 18.6476 1.45946 15.8649 1.45946H6.13513Z"
                    fill="#444444"></path>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#444444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
  <path d="M22 16.92V20a2 2 0 0 1-2.18 2c-10 0-18-8-18-18A2 2 0 0 1 4 2h3.09a2 2 0 0 1 2 1.72 12.15 12.15 0 0 0 .57 2.57 2 2 0 0 1-.45 2L8.09 8.91a16 16 0 0 0 7 7l1.62-1.62a2 2 0 0 1 2-.45 12.15 12.15 0 0 0 2.57.57 2 2 0 0 1 1.72 2z"></path>
</svg>
                </svg>
                <input type="text" name="phone" placeholder="Phone Number Ex. 1234567890" required="">
              </div>

              <div class="group-img">
                <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15.8649 18H6.13513C2.58377 18 0.540527 15.9568 0.540527 12.4054V5.5946C0.540527 2.04324 2.58377 0 6.13513 0H15.8649C19.4162 0 21.4595 2.04324 21.4595 5.5946V12.4054C21.4595 15.9568 19.4162 18 15.8649 18ZM6.13513 1.45946C3.35242 1.45946 1.99999 2.81189 1.99999 5.5946V12.4054C1.99999 15.1881 3.35242 16.5406 6.13513 16.5406H15.8649C18.6476 16.5406 20 15.1881 20 12.4054V5.5946C20 2.81189 18.6476 1.45946 15.8649 1.45946H6.13513Z"
                    fill="#444444"></path>
                  <path
                    d="M10.9988 9.8465C10.1815 9.8465 9.35452 9.59352 8.72208 9.07785L5.67668 6.64539C5.36532 6.39241 5.30696 5.93511 5.55992 5.62376C5.8129 5.31241 6.2702 5.25403 6.58155 5.50701L9.62695 7.93947C10.3664 8.53298 11.6215 8.53298 12.361 7.93947L15.4064 5.50701C15.7178 5.25403 16.1848 5.30268 16.428 5.62376C16.681 5.93511 16.6324 6.40214 16.3113 6.64539L13.2659 9.07785C12.6432 9.59352 11.8161 9.8465 10.9988 9.8465Z"
                    fill="#444444"></path>
                </svg>
                <input type="text" name="email" placeholder="Email Address" required="">
              </div>
              
              <center> <button type="submit" class="btn">Book Seat Now</button></center>
            </form>
          </div>
        </div>
      </div>
      <img alt="shaps" class="shaps" src="assets/img/footer-shaps.png">
    </section>
    <footer>
      <div class="container">
        <div class="footer-text">
          <img alt="shaps" class="shaps" src="assets/img/footer-shaps.png">
          <h2>One Destination for Complete Exam Preparation</h2>
          <p>This sets the tone for comprehensive, all-in-one support for exam preparation. Now, let's build content
            around it
          </p>
          <a href="https://testbook.com/jee-main/test-series" target="_blank" class="btn">Explore Full Test Series</a>
        </div>
        <p class="footer-p">Copyright © 2014-2024 Testbook Edu Solutions Pvt. Ltd.: All rights reserved
        </p>
      </div>
    </footer>
    <!-- progress -->
    <div id="progress">
      <span id="progress-value"><i class="fa-solid fa-arrow-up"></i></span>
    </div>
    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- fancybox -->
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- Email Js -->
    <script src="assets/js/sweetalert.min.js"></script>
  </body>
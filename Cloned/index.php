<!--------------------------------------------------------------------------------------------------------------------------------->
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

<!--------------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All India IIT & JEE Test By Testbook.</title>
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://testbook.com/assets/img/brand/logo-32x32.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<!--------------------------------------------------------------------------------------------------------------------------------->

<body>
<!-- Progress Bar Wrapper -->
<!-- Logo -->
<img src="./img/testbook-logo.png" alt="Logo" class="logo">
<!-- Replace with your logo path -->

<!-- Tagline -->
<h2 class="tagline">Crack UPSC CSE 2024 in 1st attempt with India's Top Coaching</h2>

<!-- Main Content -->
<div class="main-content container">
<div class="row">
<!-- Left Side Image and List -->
<div class="col-md-6">
<div class="image-container">
<img src="./img/test.jpg" alt="UPSC 2024" class="img-fluid">
<!-- Replace with your image path -->
</div>

<!-- New Section Below Image -->
<div class="features-list mt-4">
<h3 class="text-white">How Supercoaching can help for your UPSC Preparation?</h3>
<ul class="custom-tick-list text-white">
<li>All-in-One Coaching for UPSC CSE: Prelims, Mains, and Interview.</li>
<li>Dedicated NCERT foundation courses to strengthen your basics.</li>
<li>Access to 40+ UPSC courses, 1000+ Live Classes, 550+ Mock Tests, 500+ Study Notes, and 2500+
Practice Questions.</li>
<li>Extensive coverage of Environment, Science and Technology, and Geography (~40% weightage).
</li>
</ul>
</div>
</div>

<!-- Right Side Form -->
<div class="form-container">
<div class="card">
<h3 class="card-title">
<center>All India IIT - JEE Test</center>
</h3>
<div class="active-users">
<img src="./img/usersBubble.svg" alt="Active Users">
<span>10000 + Active Users</span>
</div>


<form id="bookingForm" action="" method="post">
<div class="form-group">
<input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
required>
</div>
<div class="form-group">
<input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number Ex. +91 7827046470" required>
</div>
<div class="form-group">
<input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
required>
</div>
<div class="form-group">
<select class="form-control" id="slot" name="slot" required>
<option value=""> Choose Time Slot </option>
<option value="morning">Morning (9:00 AM - 12:00 PM)</option>
<option value="afternoon">Afternoon (12:00 PM - 3:00 PM)</option>
<option value="evening">Evening (3:00 PM - 6:00 PM)</option>
</select>
</div>
<button type="submit" class="btn btn-primary btn-block btn-custom">Book Now</button>
</form>
</div>
</div>
</div>
</div>

<!--------------------------------------------------------------------------------------------------------------------------------->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--------------------------------------------------------------------------------------------------------------------------------->
</body>
</html>
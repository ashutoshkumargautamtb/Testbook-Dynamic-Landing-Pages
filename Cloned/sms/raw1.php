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
        $authkey = "your-msg91-authkey";           // Your MSG91 Auth key
        $template_id = "your-msg91-flow-template-id";     // Your MSG91 Flow Template ID
        $mobile = "91" . $phone;                  // Recipient's mobile number with country code
        $otp_expiry = 5;                          // OTP expiry in minutes (optional)

        // Prepare the data to be sent via the API
        $data = [
            'flow_id' => $template_id,
            'sender' => 'MSGIND',  // Replace with your approved sender ID
            'mobiles' => $mobile,
            'OTP' => $otp,          // Passing the OTP to the template variable
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

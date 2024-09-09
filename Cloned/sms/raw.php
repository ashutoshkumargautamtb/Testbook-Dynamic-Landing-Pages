<?php
// Initialize cURL session
$curl = curl_init();

// Set up the parameters for the API request
$authkey = "362200A3B0DKIEL66dacef9P1";           // Your MSG91 Auth key
$template_id = "66d9a2d0d6fc054d9457e433";     // Your MSG91 Flow Template ID
$mobile = "917827046470";                  // Recipient's mobile number with country code
$otp = rand(100000, 999999);               // Generate a random OTP

// Prepare the data to be sent via the API
$data = [
    'flow_id' => $template_id,
    'sender' => 'TESTBK',  // Replace with your approved sender ID
    'mobiles' => $mobile,
    'OTP' => $otp,          // Passing the OTP to the template variable
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
    echo "cURL Error #:" . $err;
} else {
    echo $response;  // Output the API response to check if the SMS was sent successfully
}
?>

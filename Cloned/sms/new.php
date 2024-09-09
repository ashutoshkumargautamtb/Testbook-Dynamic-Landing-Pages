<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"66d9a2d0d6fc054d9457e433\": \"1107172553470675487\",\n  \"short_url\": \"0\",\n  \"realTimeResponse\": \"1 (Optional)\", \n  \"recipients\": [\n    {\n      \"mobiles\": \"917827046470\",\n      \"VAR1\": \"VALUE 1\",\n      \"VAR2\": \"VALUE 2\"\n    }\n  ]\n}",
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authkey: 1107172553470675487",
    "content-type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>
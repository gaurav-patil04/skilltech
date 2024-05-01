<?php
// header('Refresh: 10');
$curl = curl_init();

include 'connect.php';

$query = "SELECT * FROM `authorizations`";
$query_result = mysqli_query($conn, $query);

if ($query_result && mysqli_num_rows($query_result) > 0) {
  $query_row = mysqli_fetch_assoc($query_result);

  $decryption_key = '123456789012345678901234567890012';
  $cipher = "AES-256-CBC";
  $options = 0;
  $iv = str_repeat("0",openssl_cipher_iv_length($cipher));

  $encrypted_clientid = $query_row['clientid'];
  $encrypted_clientsecret = $query_row['clientsecret'];

  // Decrypt clientid
  $decrypted_clientid = openssl_decrypt($encrypted_clientid, $cipher, $decryption_key, $options, $iv);

  // Decrypt clientsecret
  $decrypted_clientsecret = openssl_decrypt($encrypted_clientsecret, $cipher, $decryption_key, $options, $iv);

}

// Select all link_ids from link_details
$sql = "SELECT link_id FROM link_details";
$result1 = mysqli_query($conn, $sql);

// Set up cURL options outside the loop
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'x-api-version: 2023-08-01',
        'Accept: application/json',
        'x-client-id: '.$decrypted_clientid,
        'x-client-secret: '.$decrypted_clientsecret
    ),
));

// Iterate over each row in the result
while ($row = mysqli_fetch_assoc($result1)) {
    $link_id = $row['link_id'];

    // Construct the URL with the current link_id
    $url = 'https://sandbox.cashfree.com/pg/links/' . $link_id;

    // Set the URL in the cURL options
    curl_setopt($curl, CURLOPT_URL, $url);

    // Execute cURL request
    $response = curl_exec($curl);

    // Decode JSON response
    $result = json_decode($response);

    // Extract and store data in the database
    // $customer_name = $result->customer_details->customer_name;
    // echo $customer_name;
    // $customer_phone = $result->customer_details->customer_phone;
    // echo $customer_phone;
    // $customer_email = $result->customer_details->customer_email;
    // echo $customer_email;
    // $link_amount = $result->link_amount;
    // echo $link_amount;
    // $link_purpose = $result->link_purpose;
    // echo $link_purpose;
    // $link_status = $result->link_status;
    // echo $link_status;

    if ($result && isset($result->customer_details)) {
        // Check if the record already exists in the database
        $checkSql = "SELECT * FROM fetch_pl_details WHERE link_id = '$link_id'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) == 0) {
            // Record doesn't exist, so insert the data into the database
            $customer_name = $result->customer_details->customer_name;
            // echo $customer_name;
            $customer_phone = $result->customer_details->customer_phone;
            // echo $customer_phone;
            $customer_email = $result->customer_details->customer_email;
            // echo $customer_email;
            $link_amount = $result->link_amount;
            // echo $link_amount;
            $link_purpose = $result->link_purpose;
            // echo $link_purpose;
            $link_status = $result->link_status;
            // echo $link_status;
            $link_created_at = $result->link_created_at;
            // echo $link_created_at;

            // Construct and execute SQL query to insert data into the database
            $insertSql = "INSERT INTO fetch_pl_details (link_id, customer_name, customer_phone, customer_email, link_created_at, link_amount, link_purpose, link_status) 
                          VALUES ('$link_id', '$customer_name', '$customer_phone', '$customer_email','$link_created_at', '$link_amount', '$link_purpose', '$link_status')";
            
            mysqli_query($conn, $insertSql);
        }
        else {
            // Record exists, update the data if link status is different
            $existingRow = mysqli_fetch_assoc($checkResult);
            if ($existingRow['link_status'] != $result->link_status) {
                $link_status = $result->link_status;
                // Update link status in the database
                $updateSql = "UPDATE fetch_pl_details SET link_status = '$link_status' WHERE link_id = '$link_id'";
                mysqli_query($conn, $updateSql);
            }
        }
    }

}

// Close cURL outside the loop
curl_close($curl);

?>
<?php 
$api = "https://api.unleashedsoftware.com/";
$api_id = "6aaf88e3-305d-407f-843f-a524d1e09323"; // replace with live credentials
$api_key = "b7JuOv96bu16Pt1G6rLCNpqcrNi6SKi7cev9sVhBqik9lxCTKgkzInuEcwanMcnq5kqetQMOKrS593xv7lw=="; //

include_once( DIR . '/apis/unleashed-to-woo.php' );
include_once( DIR . '/apis/unleashed-customers-sync.php' );
include_once( DIR . '/apis/unleashed-salesorder.php' );

// Create Giud for Unleashed
function bt_eden_generate_guid() {
    return strtolower( sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)));
}

// Function to generate Unleashed API signature
function bt_eden_getSignature($request, $key) {
    return base64_encode(hash_hmac('sha256', $request, $key, true));
}

function bt_eden_getCurl($id, $key, $signature, $endpoint, $requestUrl, $format) {
    global $api;
  
    $curl = curl_init($api . $endpoint . $requestUrl);
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/$format",
          "Accept: application/$format", "api-auth-id: $id", "api-auth-signature: $signature"));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    // these options allow us to read the error message sent by the API
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_HTTP200ALIASES, range(400, 599));
  
    return $curl;
}
    
  // POST something to the API
function bt_eden_post_to_unleashed($id, $key, $endpoint, $format, $dataId, $data) {
    if (!isset($dataId, $data)) { return null; }

    try {
        // calculate API signature
        $signature = bt_eden_getSignature("", $key);
        // create the curl object.
        // - POST always requires the object's id
        $curl = bt_eden_getCurl($id, $key, $signature, "$endpoint/$dataId", "", $format);
        // set extra curl options required by POST
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // POST something
        $curl_result = curl_exec($curl);
        // error_log($curl_result);
        curl_close($curl);
        return $curl_result;
    }
    catch (Exception $e) {
        error_log('Error: ' + $e);
    }
}
  
function bt_eden_get_from_unleashed($id, $key, $endpoint, $request, $format) {
    $requestUrl = "";
    if (!empty($request)) $requestUrl = "?$request";

    try {
        // calculate API signature
        $signature = bt_eden_getSignature($request, $key);
        // create the curl object
        $curl = bt_eden_getCurl($id, $key, $signature, $endpoint, $requestUrl, $format);
        // GET something
        $curl_result = curl_exec($curl);
        // error_log($curl_result);
        curl_close($curl);
        return $curl_result;
    }
    catch (Exception $e) {
        error_log('Error: ' + $e);
    }
}
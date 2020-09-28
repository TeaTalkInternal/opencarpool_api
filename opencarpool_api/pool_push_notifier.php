<?php

function getOwnerDeviceToken($owner_email)
{

    require 'db_connect_credentials.php';
    header("Access-Control-Allow-Origin: *");

    $conn1 = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

    if (!$conn1) {
        echo 'Could not connect to mysql';
        exit;
    }

    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y/m/d h:i:s', time());

    $qwwuery = mysqli_connect($host_name, $db_user_name, $db_user_password);
    mysqli_select_db($db_name, $qwwuery);
    $unixtime = strtotime("now");
    
    $fireSql = "SELECT deviceToken FROM MyPoolLogin WHERE email =" . $owner_email . ";";
    $trip_query = mysqli_query($conn1,$fireSql);
    
     //echo $fireSql;
    
    if (!$trip_query) {
        echo 'Could not run trip_query: ';
        exit;
    }
    $row = mysqli_fetch_row($trip_query);
    $device_token_fetched = $row[0];
    mysqli_close($conn1);
    return $device_token_fetched;
}

function trip_booked($owner_eml, $booked_message, $booking_ids)
{
//    initalise();
    $token_val = getOwnerDeviceToken($owner_eml);
    sendNotification($booked_message, $token_val, $booking_ids, 1);
}

function trip_un_booked($owner_eml, $booked_message, $booking_ids)
{
//    initalise();
    $token_val = getOwnerDeviceToken($owner_eml);
    sendNotification($booked_message, $token_val, $booking_ids, 2);
}

function trip_accept($seeker_eml, $booked_message, $booking_ids)
{

    $token_val = getOwnerDeviceToken($seeker_eml);
    //  initalise();
    sendNotification($booked_message, $token_val, $booking_ids, 3);
}

function trip_delete($seeker_eml, $booked_message, $booking_ids)
{
//    initalise();
    $token_val = getOwnerDeviceToken($seeker_eml);
    sendNotification($booked_message, $token_val, $booking_ids, 4);
}

function traveller_removed($seeker_eml, $booked_message, $booking_ids)
{
//    initalise();
    $token_val = getOwnerDeviceToken($seeker_eml);
    sendNotification($booked_message, $token_val, $booking_ids, 5);
}

function sendNotification($messageStr, $deviceTokenStr, $booking_id, $notif_Type)
{
    //  require 'db_connect_credentials.php';
    // header("Access-Control-Allow-Origin: *");
    // Put your device token here (without spaces):
    $deviceToken = $deviceTokenStr;

    if (empty($deviceToken)) {
        //echo 'deviceToken is either 0, empty, or not set at all';
    } else {

// Put your private key's passphrase here:
        $passphrase = '';

        $data = json_decode(file_get_contents('php://input'), true);

        $title = $messageStr;
        $message = $messageStr;

// Create the payload body

        $body['trip_detail'] = array(
            'trip_id' => $booking_id,
            'notification_type' => $notif_Type,
        );

        define('API_ACCESS_KEY', 'AAAAlYEzWjc:APA91bHdON27YE3wXuDupPDqW5neLOJXXuWYj-88TLByNFoGerVOGWMLrC7jQtmcaDGuRfZO0xJGbKeGgzBkXabKnBBGcoMq2pGkY5k2P47Q-h6mWU9C1QPHIzB59FhD0SxNmkB7meZW');

        $singleID = $deviceToken;
        $registrationIDs = array(
            $deviceToken,
        );

// 'vibrate' available in GCM, but not in FCM
        $fcmMsg = array(
            'body' => $message,
            'title' => $title,
            'sound' => "default",
            'color' => "#203E78",
            "content_available" => 1,

        );

        $fcmFields = array(
            'to' => $singleID,
            'priority' => 'high',
            'notification' => $fcmMsg,
            'data' => $body,
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        curl_close($ch);

    }

}

function removeAllBookedusersFromTrip($messageStr1, $booking_ids1, $notif_Type1)
{

    require 'db_connect_credentials.php';
    header("Access-Control-Allow-Origin: *");

    $conn2 = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

    if (!$conn2) {
        echo 'Could not connect to mysql';
        exit;
    }

    date_default_timezone_set("Asia/Kolkata");
    $date1 = date('Y/m/d h:i:s', time());

    $qwwuery1 = mysqli_connect($host_name, $db_user_name, $db_user_password);
    mysqli_select_db($db_name, $qwwuery1);
    $unixtime = strtotime("now");

    $sql2 = "DELETE from MyPoolBookingInfo
                  WHERE  bookedTripID = " . $booking_ids1 . ";";

    if (mysqli_query($conn2, $sql2)) {

    } else {

    }

    mysqli_close($conn2);

}

function sendNotificationToMultipleDevices($messageStr, $booking_ids, $notif_Type)
{
    require 'db_connect_credentials.php';
    header("Access-Control-Allow-Origin: *");

    $conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

    if (!$conn) {
        echo 'Could not connect to mysql';
        exit;
    }

    date_default_timezone_set("Asia/Kolkata");
    $date1 = date('Y/m/d h:i:s', time());

    $qwwuery1 = mysqli_connect($host_name, $db_user_name, $db_user_password);
    mysqli_select_db($db_name, $qwwuery1);
    $unixtime = strtotime("now");

    $sql = "SELECT deviceToken FROM MyPoolLogin WHERE email  IN (SELECT  bookieEmail FROM MyPoolBookingInfo WHERE bookedTripID = " . $booking_ids . ")";
    $response_array = array();

    $product_type_result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($product_type_result) > 0) {
        while ($rows = mysqli_fetch_assoc($product_type_result)) {

            $response_array[] = $rows['deviceToken'];
        }
    }

    foreach ($response_array as $device_token_str) {
        sendNotification($messageStr, $device_token_str, $booking_ids, $notif_Type);
    }

    removeAllBookedusersFromTrip($messageStr, $booking_ids, $notif_Type);

    mysqli_free_result($product_type_result);

    mysqli_close($conn);

}

<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}
date_default_timezone_set("Asia/Kolkata");

$bookedTripID_val = isset($_GET['bookedTripID']) ? "'" . $_GET['bookedTripID'] . "'" : "";

$sql = "SELECT ownerEmail,isBooked,isPending,isExpired,seatsBooked,totalSeatsOffered,bookieEmail,bookiePhoneNumber,
  bookedTripID,message,messageTag,deviceToken,ownerPhoneNumber,deviceType
         FROM MyPoolBookingInfo where bookedTripID = " . $bookedTripID_val . "";

$product_type_result = mysqli_query($conn, $sql);

if (!$product_type_result) {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "No related trip details found in our server."';
    echo "}";
    exit;
}

$response_array = array();

while ($row = mysqli_fetch_assoc($product_type_result)) {

    $tmpBusArray = array(
        'ownerEmail' => $row['ownerEmail'],
        'isBooked' => $row['isBooked'],
        'isPending' => $row['isPending'],
        'isExpired' => $row['isExpired'],
        'seatsBooked' => $row['seatsBooked'],
        'totalSeatsOffered' => $row['totalSeatsOffered'],
        'bookieEmail' => $row['bookieEmail'],
        'bookiePhoneNumber' => $row['bookiePhoneNumber'],
        'bookedTripID' => $row['bookedTripID'],
        'message' => $row['message'],
        'messageTag' => $row['messageTag'],
        'deviceToken' => $row['deviceToken'],
        'ownerPhoneNumber' => $row['ownerPhoneNumber'],
        'deviceType' => $row['deviceType'],
    );
    $response_array[] = $tmpBusArray;

}

$results_count = count($response_array);

echo "{";
echo '"status_code" : 200,';
echo '"count" : ' . $results_count . ',';
echo '"status_message" : "successfully fetched data",';

if (count($response_array) >= 0) {

    echo '"bookies" :' . json_encode($response_array);
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

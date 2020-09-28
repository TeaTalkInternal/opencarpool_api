<?php require 'db_connect_credentials.php';
include "pool_push_notifier.php";

header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$date = date('Y/m/d h:i:s', time());

$qwwuery = mysqli_connect($host_name, $db_user_name, $db_user_password);
mysqli_select_db($db_name, $qwwuery);

$unixtime = strtotime("now");

$decoded = json_decode(file_get_contents('php://input'), true);

$bookedTripID_val = isset($decoded['bookedTripID']) ? "" . $decoded['bookedTripID'] . "" : 0;
$bookieEmail_val = isset($decoded['bookieEmail']) ? "'" . $decoded['bookieEmail'] . "'" : "\"\"";
$seatsBooked_val = isset($decoded['seatsBooked']) ? "" . $decoded['seatsBooked'] . "" : 0;

$ownerEmail_val = isset($decoded['ownerEmail']) ? "'" . $decoded['ownerEmail'] . "'" : "\"\"";
$ownerEmailTrimmedName = substr($ownerEmail_val, strpos($ownerEmail_val, "<") + 1, strrpos($ownerEmail_val, "@") - strpos($ownerEmail_val, "<") - 1);

//POOLTrip Table

$trip_query = mysqli_query($conn, "SELECT seatsBooked FROM MyPoolPoolTrip WHERE uniqueid_val =" . $bookedTripID_val . "");

if (!$trip_query) {
    echo 'Could not run trip_query: ';
    exit;
}
$row = mysqli_fetch_row($trip_query);

$earlierBookedSeats = $row[0];

$newseatscount = $earlierBookedSeats + $seatsBooked_val;

//Booking INFo

$trip_query_book_info = mysqli_query($conn, "SELECT isBooked FROM MyPoolBookingInfo WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";");
if (!$trip_query_book_info) {
    echo 'Could not run trip_query_book_info: ';
    exit;
}
$row_info = mysqli_fetch_row($trip_query_book_info);

$isBooked_info_val = $row_info[0];

if ($isBooked_info_val == 0) {

    $updatesql = "UPDATE MyPoolBookingInfo SET isBooked =  1,isPending=  0,
seatsBooked=  " . $seatsBooked_val . "
 WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";";

    $updatesql .= "UPDATE MyPoolPoolTrip SET isBooked =  1,isPending=  0
 WHERE uniqueid_val = " . $bookedTripID_val . ";";

    if (mysqli_multi_query($conn, $updatesql)) {

        $trip_detail_Strs = "" . $ownerEmailTrimmedName . " has accepted your request for " . $seatsBooked_val . " seats.";
        trip_accept($bookieEmail_val, $trip_detail_Strs, $bookedTripID_val);

        echo "{";
        echo '"status_code" : 200,';
        echo '"status_message" : "Successfuly accepted  ' . $seatsBooked_val . ' seat request."';
        echo "}";

    } else {
        echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Failed to accept."';
        echo "}";

    }

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

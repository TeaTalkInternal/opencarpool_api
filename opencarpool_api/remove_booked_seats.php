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

$trip_detail_Strs = "" . $ownerEmailTrimmedName . " has removed the trip.";

$trip_detail_Strs = "" . $ownerEmailTrimmedName . " has removed you from trip.";
traveller_removed($bookieEmail_val, $trip_detail_Strs, $bookedTripID_val);

//POOLTrip Table

$trip_query = mysqli_query($conn, "SELECT seatsBooked FROM MyPoolPoolTrip WHERE uniqueid_val =" . $bookedTripID_val . "");

if (!$trip_query) {
    echo 'Could not run trip_query: ';
    exit;
}
$row = mysqli_fetch_row($trip_query);

$earlierBookedSeats = $row[0];

$newseatscount = $earlierBookedSeats - $seatsBooked_val;

$updatesql = "UPDATE MyPoolPoolTrip SET seatsBooked = " . $newseatscount . "
 WHERE uniqueid_val = " . $bookedTripID_val . ";";

$updatesql .= "DELETE from MyPoolBookingInfo
                  WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";";

if (mysqli_multi_query($conn, $updatesql)) {

    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Successfuly Removed ' . $seatsBooked_val . '"';
    echo "}";

} else {
    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "Failed to remove seats."';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

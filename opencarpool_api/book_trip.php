<?php

require 'db_connect_credentials.php';
include "pool_push_notifier.php";

header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$date = date('Y/m/d h:i:s', time());

$unixtime = strtotime("now");

$qwwuery = mysqli_connect($host_name, $db_user_name, $db_user_password);
mysqli_select_db($db_name, $qwwuery);

$decoded = json_decode(file_get_contents('php://input'), true);

$ownerEmail_val = isset($decoded['ownerEmail']) ? "'" . $decoded['ownerEmail'] . "'" : "\"\"";

$seatsBooked_val = isset($decoded['seatsBooked']) ? "" . $decoded['seatsBooked'] . "" : 0;
$totalSeatsOffered_val = isset($decoded['totalSeatsOffered']) ? "" . $decoded['totalSeatsOffered'] . "" : 0;
$bookieEmail_val = isset($decoded['bookieEmail']) ? "'" . $decoded['bookieEmail'] . "'" : "\"\"";
$bookiePhoneNumber_val = isset($decoded['bookiePhoneNumber']) ? "'" . $decoded['bookiePhoneNumber'] . "'" : "\"\"";
$bookie_name_val = isset($decoded['bookieName']) ? "'" . $decoded['bookieName'] . "'" : "\"\"";
$bookedTripID_val = isset($decoded['bookedTripID']) ? "" . $decoded['bookedTripID'] . "" : 0;
$ownerPhoneNumber_val = isset($decoded['ownerPhoneNumber']) ? "'" . $decoded['ownerPhoneNumber'] . "'" : "\"\"";
$deviceType_val = isset($decoded['deviceType']) ? "" . $decoded['deviceType'] . "" : 0;


$sql1 = "SELECT * FROM MyPoolPoolTrip WHERE uniqueid_val = " . $bookedTripID_val . ";";

$trip_query_result = mysqli_query($conn,$sql1);

if (!$trip_query_result) {
     echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Could not run trip_query."';
        echo "}";
   exit;
}
$row = mysqli_fetch_row($trip_query_result);

$earlierBookedSeats = $row[0]; // 42

$newseatscount = $earlierBookedSeats + $seatsBooked_val;

$bookieEmailTrimmedName = substr($bookieEmail_val, strpos($bookieEmail_val, "<") + 1, strrpos($bookieEmail_val, "@") - strpos($bookieEmail_val, "<") - 1);

$selectsql = "SELECT  bookieEmail FROM MyPoolBookingInfo WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";";

$product_type_result = mysqli_query($conn, $selectsql);

$num_rows = mysqli_num_rows($product_type_result);

if ($num_rows <= 0) {

    $sqls = "INSERT INTO MyPoolBookingInfo (ownerEmail,isBooked,isPending,isExpired,seatsBooked,totalSeatsOffered,bookieEmail,bookiePhoneNumber,
  bookedTripID,message,messageTag,deviceToken,ownerPhoneNumber,deviceType,bookieName)
 VALUES ($ownerEmail_val,0,1,0,$seatsBooked_val,$totalSeatsOffered_val,$bookieEmail_val,$bookiePhoneNumber_val,
  $bookedTripID_val,'',0,'',$ownerPhoneNumber_val,$deviceType_val,$bookie_name_val);";

    $sqls .= "UPDATE MyPoolPoolTrip SET isBooked =  0,isPending =  1,
seatsBooked=  " . $newseatscount . "
 WHERE uniqueid_val = " . $bookedTripID_val . ";";


    if (mysqli_multi_query($conn, $sqls)) {

        $trip_detail_Strs = "" . $bookieEmailTrimmedName . " is requesting " . $seatsBooked_val . " seats.";

        trip_booked($ownerEmail_val, $trip_detail_Strs, $bookedTripID_val);

        echo "{";
        echo '"status_code" : 200,';
        echo '"status_message" : "Successfuly Booked the trip"';
        echo "}";

    } else {

        echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Failed to Book."';
        echo "}";

    }

} else {

    $updatesql = "UPDATE MyPoolBookingInfo SET ownerEmail=  " . $ownerEmail_val . ",bookieName=  " . $bookie_name_val . ",isPending=  1,
seatsBooked=  " . $seatsBooked_val . ",totalSeatsOffered=  " . $totalSeatsOffered_val . ",
bookieEmail=  " . $bookieEmail_val . ",bookiePhoneNumber=  " . $bookiePhoneNumber_val . ",bookedTripID=  " . $bookedTripID_val . ",
ownerPhoneNumber=  " . $ownerPhoneNumber_val . ",deviceType=  " . $deviceType_val . "
 WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";";

    $updatesql .= "UPDATE MyPoolPoolTrip SET isBooked =  0,isPending =  1,
seatsBooked=  " . $newseatscount . "
 WHERE uniqueid_val = " . $bookedTripID_val . ";";
 
 //echo $updatesql;

    if (mysqli_multi_query($conn, $updatesql)) {

        $trip_detail_Str = "" . $bookieEmailTrimmedName . " is requesting " . $seatsBooked_val . " seats.";
        trip_booked($ownerEmail_val, $trip_detail_Str, $bookedTripID_val);

        echo "{";
        echo '"status_code" : 200,';
        echo '"status_message" : "Successfuly Booked the trip"';
        echo "}";

    } else {
        echo "{";
        echo '"status_code" : 400,';

        echo '"status_message" : "Failed to Book."';
        echo "}";

    }

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

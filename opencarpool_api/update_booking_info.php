<?php require 'db_connect_credentials.php';

header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$date = date('Y/m/d h:i:s', time());

$unixtime = strtotime("now");

$decoded = json_decode(file_get_contents('php://input'), true);

$trip_path = isset($decoded['trip_path']) ? "'" . $decoded['trip_path'] . "'" : "\"\"";

$ownerEmail_val = isset($decoded['ownerEmail']) ? "'" . $decoded['ownerEmail'] . "'" : "\"\"";
$isBooked_val = isset($decoded['isBooked']) ? "" . $decoded['isBooked'] . "" : 0;
$isPending_val = isset($decoded['isPending']) ? "" . $decoded['isPending'] . "" : 0;
$isExpired_val = isset($decoded['isExpired']) ? "" . $decoded['isExpired'] . "" : 0;
$seatsBooked_val = isset($decoded['seatsBooked']) ? "" . $decoded['seatsBooked'] . "" : 0;
$totalSeatsOffered_val = isset($decoded['totalSeatsOffered']) ? "" . $decoded['totalSeatsOffered'] . "" : 0;
$bookieEmail_val = isset($decoded['bookieEmail']) ? "'" . $decoded['bookieEmail'] . "'" : "\"\"";
$bookiePhoneNumber_val = isset($decoded['bookiePhoneNumber']) ? "'" . $decoded['bookiePhoneNumber'] . "'" : "\"\"";
$bookedTripID_val = isset($decoded['bookedTripID']) ? "" . $decoded['bookedTripID'] . "" : 0;
$message_val = isset($decoded['message']) ? "'" . $decoded['message'] . "'" : "\"\"";
$messageTag_val = isset($decoded['messageTag']) ? "" . $decoded['messageTag'] . "" : 0;
$deviceToken_val = isset($decoded['deviceToken']) ? "'" . $decoded['deviceToken'] . "'" : "\"\"";
$ownerPhoneNumber_val = isset($decoded['ownerPhoneNumber']) ? "'" . $decoded['ownerPhoneNumber'] . "'" : "\"\"";
$deviceType_val = isset($decoded['deviceType']) ? "" . $decoded['deviceType'] . "" : 0;

$uniqueID_val = $unixtime;

$selectsql = "SELECT  bookieEmail FROM MyPoolBookingInfo WHERE bookieEmail = '" . $bookieEmail_val . "' AND bookedTripID = " . $bookedTripID_val . ";";

$product_type_result = mysqli_query($conn, $selectsql);

$num_rows = mysqli_num_rows($product_type_result);

if ($num_rows <= 0) {

    $sqls = "INSERT INTO MyPoolBookingInfo (ownerEmail,isBooked,isPending,isExpired,seatsBooked,totalSeatsOffered,bookieEmail,bookiePhoneNumber,
  bookedTripID,message,messageTag,deviceToken,ownerPhoneNumber,deviceType)
 VALUES ($ownerEmail_val,$isBooked_val,$isPending_val,$isExpired_val,$seatsBooked_val,$totalSeatsOffered_val,$bookieEmail_val,$bookiePhoneNumber_val,
  $bookedTripID_val,$message_val,$messageTag_val,$deviceToken_val,$ownerPhoneNumber_val,$deviceType_val);";

    if (mysqli_query($conn, $sqls)) {

        echo "{";
        echo '"status_code" : 200,';
        echo '"status_message" : "Successfuly Signed-In"';
        echo "}";

    } else {

        echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Failed to Sign-In. Please check your email and password."';
        echo "}";

    }

} else {

//lets update  the existing email with phone number

    $updatesql = "UPDATE MyPoolBookingInfo SET ownerEmail=  " . $ownerEmail_val . ",isBooked=  " . $isBooked_val . ",isPending=  " . $isPending_val . ",
isExpired=  " . $isExpired_val . ",seatsBooked=  " . $seatsBooked_val . ",totalSeatsOffered=  " . $totalSeatsOffered_val . ",
bookieEmail=  " . $bookieEmail_val . ",bookiePhoneNumber=  " . $bookiePhoneNumber_val . ",bookedTripID=  " . $bookedTripID_val . ",
message=  " . $phone_number_val . ",messageTag=  " . $phone_number_val . ",deviceToken=  " . $phone_number_val . ",
ownerPhoneNumber=  " . $ownerPhoneNumber_val . ",deviceType=  " . $deviceType_val . "
 WHERE bookieEmail = " . $bookieEmail_val . " AND bookedTripID = " . $bookedTripID_val . ";";

    if (mysqli_query($conn, $updatesql)) {

        echo "{";
        echo '"status_code" : 200,';
        echo '"status_message" : "Successfuly Signed-In"';
        echo "}";

    } else {
        echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Failed to Sign-In. Please check your email and password."';
        echo "}";

    }

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

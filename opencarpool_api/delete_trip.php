<?php require 'db_connect_credentials.php';
include "pool_push_notifier.php";

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$decoded = json_decode(file_get_contents('php://input'), true);

$uniqueid_val = isset($decoded['uniqueid']) ? "" . $decoded['uniqueid'] . "" : 0.0;
$ownerEmail_val = isset($decoded['ownerEmail']) ? "'" . $decoded['ownerEmail'] . "'" : "\"\"";
$ownerEmailTrimmedName = substr($ownerEmail_val, strpos($ownerEmail_val, "<") + 1, strrpos($ownerEmail_val, "@") - strpos($ownerEmail_val, "<") - 1);

$sql = "UPDATE MyPoolPoolTrip SET is_trip_live =  0 , seatsBooked = 0 WHERE uniqueid_val = " . $uniqueid_val . ";";

if (mysqli_query($conn, $sql)) {

    $trip_detail_Strs = "" . $ownerEmailTrimmedName . " has removed the trip.";
    sendNotificationToMultipleDevices($trip_detail_Strs, $uniqueid_val, 6);

    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Trip deleted successfully."';
    echo "}";

} else {
    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "Failed to delete trip."';
    echo "}";

}
mysqli_close($conn);

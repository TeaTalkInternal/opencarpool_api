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

$email_val = isset($decoded['email']) ? "'" . $decoded['email'] . "'" : "\"\"";
$deviceToken_val = isset($decoded['deviceToken']) ? "'" . $decoded['deviceToken'] . "'" : "\"\"";

$updatesql = "UPDATE MyPoolLogin SET deviceToken =  " . $deviceToken_val . " WHERE email = " . $email_val . ";";

if (mysqli_query($conn, $updatesql)) {

    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Successfuly Added Device Token"';
    echo "}";

} else {
    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "Failed to Add Device Token."';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

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

$phone_number_val = $decoded['phonenumber'];

$selectsql = "SELECT  phonenumber FROM MyPoolLogin WHERE phonenumber = '" . $phone_number_val . "';";

$product_type_result = mysqli_query($conn, $selectsql);

$num_rows = mysqli_num_rows($product_type_result);

if ($num_rows <= 0) {

    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Successfuly Signed-In",';
    echo '"profile" :' . json_encode($profileArr);
    echo "}";

} else {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "You have already Signed-up, Please Login."';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

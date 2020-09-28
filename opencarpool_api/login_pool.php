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

$email = $decoded['email'];
$device_token_val = $decoded['deviceToken'];
$device_type_val = $decoded['deviceType'];
$password_val = $decoded['password'];
$epassword_md5 = md5($password_val);


$selectsql = "SELECT *  FROM MyPoolLogin WHERE email = '" . $email . "' AND epassword = '".$epassword_md5."';";

$product_type_result = mysqli_query($conn, $selectsql);

if (!$product_type_result) {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "No Credentials found in our Database, Please Sign-Up."';
    echo "}";
    exit;
}

$row = mysqli_fetch_assoc($product_type_result);

$username_val = $row['username'];
$email_val = $row['email'];
$phone_number_val = $row['phonenumber'];

$num_rows = mysqli_num_rows($product_type_result);

if ($num_rows <= 0) {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "Failed to Sign-In. Please check your email and password."';
    echo "}";

} else {

    $updatesql = "UPDATE MyPoolLogin SET deviceToken =  '" . $device_token_val . "',deviceType =  '" . $device_type_val . "' WHERE phonenumber = '" . $phone_number_val . "';";

    if (mysqli_query($conn, $updatesql)) {

        $profileArr1 = array("email" => $email_val, "phonenumber" => $phone_number_val, "username" => $username_val, "jobtitle" => $jobtitle_val);

        echo "{";
        echo '"status_code" : 200,';

        echo '"status_message" : "Successfuly Signed-In",';
        echo '"profile" :' . json_encode($profileArr1);
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

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


$username_val = $decoded['username'];
$email_val = $decoded['email'];
$phone_number_val = $decoded['phonenumber'];

$device_token_val = $decoded['deviceToken'];
$device_type_val = $decoded['deviceType'];

$password_val = $decoded['password'];
$epassword_md5 = md5($password_val);

$uniqueID_val = $unixtime;

$selectsql = "SELECT  email FROM MyPoolLogin WHERE email = '" . $email_val . "';";


$product_type_result = mysqli_query($conn, $selectsql);

$num_rows = mysqli_num_rows($product_type_result);

if ($num_rows <= 0) {

    $sqls = "INSERT INTO MyPoolLogin (username, email, uniqueid,phonenumber,deviceToken,deviceType,epassword)
 VALUES ('$username_val','$email_val','$uniqueID_val','$phone_number_val','$device_token_val',$device_type_val, '$epassword_md5');";
 

    if (mysqli_query($conn, $sqls)) {

        $profileArr = array("email" => $email_val, "phonenumber" => $phone_number_val, "username" => $username_val, "jobtitle" => $jobtitle_val);

        echo "{";
        echo '"status_code" : 200,';

        echo '"status_message" : "Successfuly Signed-In",';
        echo '"profile" :' . json_encode($profileArr);
        echo "}";

    } else {

        echo "{";
        echo '"status_code" : 400,';
        echo '"status_message" : "Failed to Sign-up. Please check your email and password."';
        echo "}";

    }

} else {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "You have already Signed-up, Please Login."';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);
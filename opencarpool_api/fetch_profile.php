<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$email_name_value = isset($_GET['email']) ? "'" . $_GET['email'] . "'" : "";

$sql = "SELECT  email,phonenumber FROM MyPoolLogin WHERE ( email = " . $email_name_value . ");";

$product_type_result = mysqli_query($conn, $sql);

$response_array = array();

while ($row = mysqli_fetch_assoc($product_type_result)) {

    $tmpBusArray = array(
        'email' => $row['email'],
        'phonenumber' => $row['phonenumber'],
    );
    $response_array = $tmpBusArray;

}

$results_count = count($response_array);

if ($results_count > 0) {
    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Successfuly fetched Profile Details",';
    echo '"profile" :' . json_encode($response_array);
    echo "}";

} else {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "Failed to fetch Phone Number."';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

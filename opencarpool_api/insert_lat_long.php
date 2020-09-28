<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$date = date('Y/m/d h:i:s', time());

$records = $_POST['lat_longs'];

if (is_array($records)) {
    foreach ($records as $row) {
        $fieldVal1 = mysqli_real_escape_string($conn, $records[$row][0]);
        $fieldVal2 = mysqli_real_escape_string($conn, $records[$row][1]);
        $fieldVal3 = mysqli_real_escape_string($conn, $records[$row][2]);
        $fieldVal4 = mysqli_real_escape_string($conn, $records[$row][3]);
        $fieldVal5 = mysqli_real_escape_string($conn, $records[$row][4]);
        $fieldVal6 = mysqli_real_escape_string($conn, $records[$row][5]);
        $query = "INSERT INTO MyPoolLatLongs (latitude, longitude, routeId, distance , duration,htmlImstruction)
        VALUES ( '" . $fieldVal1 . "','" . $fieldVal2 . "','" . $fieldVal3 . "','" . $fieldVal4 . "',,'" . $fieldVal5 . "',,'" . $fieldVal6 . "')";
        mysqli_query($conn, $query);
    }

    echo "{";
    echo '"status_code" : 200,';

    echo '"status_message" : "Successfully inserted"';
    echo "}";
} else {
    echo "{";
    echo '"status_code" : 400,';

    echo '"status_message" : "Failed To Insert"';
    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

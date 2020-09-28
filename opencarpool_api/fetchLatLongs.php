<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$routeId = $_GET['routeId'];

$sql = "SELECT latitude, longitude, routeId, distance , duration,htmlImstruction,polyline,orderID
         FROM MyPoolLatLongs where routeId =" . $routeId . ";";

$product_type_result = mysqli_query($conn, $sql);

if (!$product_type_result) {

    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "No related trip details found in our server."';
    echo "}";
    exit;
}

$response_array = array();

while ($row = mysqli_fetch_assoc($product_type_result)) {

    $tmpBusArray = array(
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
        'routeId' => $row['routeId'],
        'distance' => $row['distance'],
        'duration' => $row['duration'],
        'htmlImstruction' => $row['htmlImstruction'],
        'polyline' => $row['polyline'],
        'orderID' => $row["orderID"],
    );
    $response_array[] = $tmpBusArray;

}

$results_count = count($response_array);

echo "{";
echo '"status_code" : 200,';
echo '"count" : ' . $results_count . ',';
echo '"status_message" : "successfully fetched data",';

if (count($response_array) >= 0) {

    echo '"latlongs" :' . json_encode($response_array);

    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

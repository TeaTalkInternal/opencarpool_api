<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$trip_id_val = isset($_GET['trip_id']) ? "'" . $_GET['trip_id'] . "'" : "";

$sql = "SELECT uniqueid_val,
    trip_path,
  source_name,
  destination_name,
  source_lat,
        source_lng,
        destination_lat,
        destination_lng,
  time_leaving_source, time_leaving_destination,
   number_of_seats, traveller_type, trip_type, total_trip_time,total_trip_distance,trip_via,
 phonenumber_val, email_val, is_trip_live,schedule_type,
        day1,
        day2,
        day3,
        day4,
        day5,
        day6,
        day7,
        tripDate,
        isBooked,
        isPending,
        totalSeatsOffered,
        seatsBooked
         FROM MyPoolPoolTrip where uniqueid_val = " . $trip_id_val . " and is_trip_live = 1;";

$product_type_result = mysqli_query($conn, $sql);

if (!$product_type_result) {

    echo "{";
    echo '"status_code" : 400,';
    echo '"status_message" : "No related trip details found in our server."';
    echo "}";
    exit;
}

$response_array = array();

while ($row = mysqli_fetch_assoc($product_type_result)) {

    $tmpBusArray = array(
        'trip_path' => $row['trip_path'],
        'source_name' => $row['source_name'],
        'destination_name' => $row['destination_name'],
        'source_lat' => $row['source_lat'],
        'source_lng' => $row['source_lng'],
        'destination_lat' => $row['destination_lat'],
        'destination_lng' => $row['destination_lng'],
        'time_leaving_source' => $row['time_leaving_source'],
        'time_leaving_destination' => $row['time_leaving_destination'],
        'number_of_seats' => $row['number_of_seats'],
        'traveller_type' => $row['traveller_type'],
        'trip_type' => $row['trip_type'],
        'total_trip_time' => $row['total_trip_time'],
        'total_trip_distance' => $row['total_trip_distance'],
        'trip_via' => $row['trip_via'],
        'uniqueid_val' => $row['uniqueid_val'],
        'phonenumber_val' => $row['phonenumber_val'],
        'email_val' => $row['email_val'],
        'schedule_type' => $row['schedule_type'],
        'day1' => $row['day1'],
        'day2' => $row['day2'],
        'day3' => $row['day3'],
        'day4' => $row['day4'],
        'day5' => $row['day5'],
        'day6' => $row['day6'],
        'day7' => $row['day7'],
        'tripDate' => $row['tripDate'],
        'isBooked' => $row['isBooked'],
        'isPending' => $row['isPending'],
        'totalSeatsOffered' => $row['totalSeatsOffered'],
        'seatsBooked' => $row['seatsBooked'],

    );
    $response_array[] = $tmpBusArray;

}

$results_count = count($response_array);

echo "{";
echo '"status_code" : 200,';
echo '"count" : ' . $results_count . ',';
echo '"status_message" : "successfully fetched data",';

if (count($response_array) >= 0) {

    echo '"trips" :' . json_encode($response_array);

    echo "}";

}

mysqli_free_result($product_type_result);
mysqli_close($conn);

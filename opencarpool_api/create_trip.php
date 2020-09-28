<?php require 'db_connect_credentials.php';

$conn = mysqli_connect($host_name, $db_user_name, $db_user_password, $db_name);

if (!$conn) {
    echo 'Could not connect to mysql';
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$date = date('Y/m/d h:i:s', time());

$decoded = json_decode(file_get_contents('php://input'), true);

$trip_path = isset($decoded['trip_path']) ? "'" . $decoded['trip_path'] . "'" : "\"\"";
$source_name = isset($decoded['source_name']) ? "'" . $decoded['source_name'] . "'" : "\"\"";
$destination_name = isset($decoded['destination_name']) ? "'" . $decoded['destination_name'] . "'" : "\"\"";

$source_lat = isset($decoded['source_lat']) ? "" . $decoded['source_lat'] . "" : 0.0;
$source_lng = isset($decoded['source_lng']) ? "" . $decoded['source_lng'] . "" : 0.0;

$destination_lat = isset($decoded['destination_lat']) ? "" . $decoded['destination_lat'] . "" : 0.0;
$destination_lng = isset($decoded['destination_lng']) ? "" . $decoded['destination_lng'] . "" : 0.0;

$tripDate = isset($decoded['tripDate']) ? "'" . $decoded['tripDate'] . "'" : "\"\"";
$time_leaving_source = isset($decoded['time_leaving_source']) ? "'" . $decoded['time_leaving_source'] . "'" : "\"\"";
$time_leaving_destination = isset($decoded['time_leaving_destination']) ? "'" . $decoded['time_leaving_destination'] . "'" : "\"\"";
$number_of_seats = isset($decoded['number_of_seats']) ? "" . $decoded['number_of_seats'] . "" : 0;
$traveller_type = isset($decoded['traveller_type']) ? "" . $decoded['traveller_type'] . "" : 0;
$trip_type = isset($decoded['trip_type']) ? "" . $decoded['trip_type'] . "" : 0;

$total_trip_time = isset($decoded['total_trip_time']) ? "'" . $decoded['total_trip_time'] . "'" : "\"\"";
$total_trip_distance = isset($decoded['total_trip_distance']) ? "'" . $decoded['total_trip_distance'] . "'" : "\"\"";
$trip_via = isset($decoded['trip_via']) ? "'" . $decoded['trip_via'] . "'" : "\"\"";

$uniqueid_val = isset($decoded['uniqueid']) ? "" . $decoded['uniqueid'] . "" : 0;
$phonenumber_val = isset($decoded['phone']) ? "'" . $decoded['phone'] . "'" : "\"\"";
$email_val = isset($decoded['email']) ? "'" . $decoded['email'] . "'" : "\"\"";
$is_trip_live = isset($decoded['is_trip_live']) ? "" . $decoded['is_trip_live'] . "" : 0;

$schedule_type = isset($decoded['schedule_type']) ? "" . $decoded['schedule_type'] . "" : 0;
$day1 = isset($decoded['day1']) ? "" . $decoded['day1'] . "" : 0;
$day2 = isset($decoded['day2']) ? "" . $decoded['day2'] . "" : 0;
$day3 = isset($decoded['day3']) ? "" . $decoded['day3'] . "" : 0;
$day4 = isset($decoded['day4']) ? "" . $decoded['day4'] . "" : 0;
$day5 = isset($decoded['day5']) ? "" . $decoded['day5'] . "" : 0;
$day6 = isset($decoded['day6']) ? "" . $decoded['day6'] . "" : 0;
$day7 = isset($decoded['day7']) ? "" . $decoded['day7'] . "" : 0;

$isBooked_val = isset($decoded['isBooked']) ? "" . $decoded['isBooked'] . "" : 0;
$isPending_val = isset($decoded['isPending']) ? "" . $decoded['isPending'] . "" : 0;

$records = $decoded['records'];

$sql = "INSERT INTO MyPoolPoolTrip (trip_path,
        source_name,
        destination_name,
        source_lat,
        source_lng,
        destination_lat,
        destination_lng,
        time_leaving_source,
        time_leaving_destination,
        number_of_seats,
        traveller_type,
        trip_type,
        total_trip_time,
        total_trip_distance,
        trip_via,
        uniqueid_val,
        phonenumber_val,
        email_val,
        is_trip_live,
        schedule_type,
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
        seatsBooked)
VALUES ($trip_path,
    $source_name,
    $destination_name,
    $source_lat,
        $source_lng,
        $destination_lat,
        $destination_lng,
    $time_leaving_source,
    $time_leaving_destination,
    $number_of_seats,
    $traveller_type,
    $trip_type,
    $total_trip_time,
    $total_trip_distance,
    $trip_via,
    $uniqueid_val,
    $phonenumber_val,
    $email_val,
    $is_trip_live,
    $schedule_type,
        $day1,
        $day2,
        $day3,
        $day4,
        $day5,
        $day6,
        $day7,
        $tripDate,
        $isBooked_val,
        $isPending_val,
        $number_of_seats,
        0
    );";

if (is_array($records)) {

    for ($arrayIndex = 0; $arrayIndex < count($records); $arrayIndex++) {

        $value = $records[$arrayIndex];

        $latValue = isset($value["latitude"]) ? $value["latitude"] : 0.0;
        $longValue = isset($value["longitude"]) ? $value["longitude"] : 0.0;
        $routeIdValue = isset($value["routeId"]) ? $value["routeId"] : 0.0;
        $orderIdValue = isset($value["orderID"]) ? $value["orderID"] : 0;
        $distanceValue = isset($value['distance']) ? "'" . $value['distance'] . "'" : "\"\"";
        $durationValue = isset($value['duration']) ? "'" . $value['duration'] . "'" : "\"\"";
        $htmlImstructionValue = isset($value['rawInstructions']) ? "'" . $value['rawInstructions'] . "'" : "\"\"";
        $polyline = isset($value['polyline']) ? "'" . $value['polyline'] . "'" : "\"\"";

        $sql .= "INSERT INTO MyPoolLatLongs (latitude, longitude, routeId, distance , duration,htmlImstruction,polyline,orderID)
                VALUES ($latValue,$longValue,$routeIdValue,$distanceValue,$durationValue,$htmlImstructionValue,$polyline,$orderIdValue);";
    }

}

if (mysqli_multi_query($conn, $sql)) {
    echo "{";
    echo '"status_code" : 200,';
    echo '"status_message" : "Successfully created Trip"';
    echo "}";

} else {
    echo "{";
    echo '"status_code" : 400,';
    echo '"status_code_s" :' . $sql . ',';
    echo '"status_message" : "Failed  to create trip"';
    echo "}";

}

mysqli_close($conn);

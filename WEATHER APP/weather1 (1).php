<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');

// Connect to database
$mysqli = new mysqli("localhost","root","roseville_weather");

// connecting to database
mysqli_query($mysqli, 'use roseville_weather');
// Execute SQL query
$result = mysqli_query($mysqli, 'select*from weather_data;');

// Get data, convert to JSON and print
$data = new stdClass;
while ($row = $result->fetch_assoc()) {
    $data = $row;
};
echo json_encode($data);
?>
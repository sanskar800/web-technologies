<?php

// Connect to database, create database, and select it
$mysqli = new mysqli("localhost", "root", "");
mysqli_query($mysqli, "create database if not exists roseville_weather");
mysqli_query($mysqli, "use roseville_weather");

// Create table if it doesn't exist
mysqli_query($mysqli, "create table if not exists weather_data(description varchar(20), temperature int(10), wind_speed int(10), city varchar(20), pressure int(10), humidity int(10), icon varchar(10), dt int(20))");

// URL for openweathermap API call
$url = 'https://api.openweathermap.org/data/2.5/weather?q=roseville&appid=eee482b6b1c85071a865e477e4634edc';

// Get data from openweathermap and store in JSON object
$data = file_get_contents($url);
$json = json_decode($data, true);

// Fetch required fields from JSON object
$description = $json['weather'][0]['description'];
$temperature = $json['main']['temp'];
$wind_speed = $json['wind']['speed'];
$city = $json['name'];
$pressure = $json['main']['pressure'];
$humidity = $json['main']['humidity'];
$icon = $json['weather'][0]['icon'];
$dt = $json['dt'];

// Insert data into weather_data table
mysqli_query($mysqli, "insert into weather_data(description, temperature, wind_speed, city, pressure, humidity, icon, dt) values('$description', $temperature, $wind_speed, '$city',  $pressure, $humidity, '$icon', $dt)");

// Build SQL query to retrieve weather data of past week
$sql = "SELECT * FROM weather_data WHERE dt >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 WEEK))";

// Execute SQL query and retrieve results
$result = mysqli_query($mysqli, $sql);

// Start building the table
echo "<table>";

// Loop through results and display data
while($row = mysqli_fetch_assoc($result)) {
  echo "<tr><td><strong>Description:</strong></td><td>" . $row['description'] . "</td></tr>";
  echo "<tr><td><strong>Temperature:</strong></td><td>" . $row['temperature'] . "</td></tr>";
  echo "<tr><td><strong>Wind Speed:</strong></td><td>" . $row['wind_speed'] . "</td></tr>";
  echo "<tr><td><strong>City:</strong></td><td>" . $row['city'] . "</td></tr>";
  echo "<tr><td><strong>Pressure:</strong></td><td>" . $row['pressure'] . "</td></tr>";
  echo "<tr><td><strong>Humidity:</strong></td><td>" . $row['humidity'] . "</td></tr>";
  echo "<tr><td><strong>Icon:</strong></td><td>" . $row['icon'] . "</td></tr>";
  echo "<tr><td><strong>Date/Time:</strong></td><td>" . date('Y-m-d H:i:s', $row['dt']) . "</td></tr>";
}

// End the table
echo "</table>";

?>


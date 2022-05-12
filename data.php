<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
// Select weather data for given parameters-------------------
$sql = "SELECT *
FROM weatherelement
WHERE weathercity = '{$_GET['city']}'
AND datetimes >= DATE_SUB(NOW(), INTERVAL 10 HOUR)
ORDER BY datetimes DESC limit 1";
$result = $mysqli -> query($sql);

// If 0 record found
if ($result->num_rows == 0) {
$url = 'https://api.openweathermap.org/data/2.5/weather?q='.$_GET['city'].' &appid=9936c29832144d68fa88d1b5d0293cf5&units=metric';
// Get data from openweathermap and store in JSON object
$data = file_get_contents($url);
$json = json_decode($data, true);
// Fetch required fields
$weather = $json['weather'][0]['description'];
$temperature = $json['main']['temp'];
$wind = $json['wind']['speed'];
$datetimes = date("Y-m-d H:i:s"); 
$weathercity = $json['name'];
$pressure=$json ['main'] ['pressure'];
$speed=$json['wind']['speed'];
$humidity=$json['main']['humidity'];
$icon=$json['weather'] [0] ['icon'];


// Build INSERT SQL statement
$sql = "INSERT INTO  weatherelement (weather,temperature ,wind ,datetimes ,speed ,humidity,weathercity,pressure,icon)
VALUES('{$weather}','{$temperature}','{$wind}','{$datetimes}','{$speed}','{$humidity}','{$weathercity}','{$pressure}','{$icon}')";
// Run SQL statement and report errors
//var_dump($sql);
if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");
}
}
?>
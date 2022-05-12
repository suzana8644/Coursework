<?php
// Connect to database
$mysqli = new mysqli("bjutx6zvkod5h7i9s2cv-mysql.services.clever-cloud.com","udsgkv8x2j9py0st","4IWZZVqo8UCiyvVInS7c","bjutx6zvkod5h7i9s2cv"); //it contains server,username,password and name of database respectively.
//checking connection---------------------------
if ($mysqli -> connect_error) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}
include('data.php'); //it is used to include a php file in another file.
// Execute SQL query
$sql = "SELECT *
FROM weatherelement
WHERE weathercity = '{$_GET['city']}'
AND datetimes >= DATE_SUB(NOW(), INTERVAL 10 HOUR)
ORDER BY datetimes DESC limit 1";
$result = $mysqli -> query($sql);
$result = $mysqli -> query($sql);
// Get data, convert to JSON and print
$row = $result -> fetch_assoc();
print json_encode($row);
// Free result set and close connection
$result -> free_result();
$mysqli -> close();
?>

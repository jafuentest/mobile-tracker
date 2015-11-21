<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
  $vehicle_id = $_POST['vehicle_id'];
  $date = date( "y-m-d", intval( $_POST['time'] ) / 1000 );
  $time = date( "H:i:s", intval( $_POST['time'] ) / 1000 );
  $speed = $_POST['speed'];
  $lat = $_POST['lat'];
  $lon = $_POST['lon'];
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "dbname";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
  $sql = "INSERT INTO gps_data (`vehicle_id`, `date`, `time`, `speed`, `latitude`, `longitud`)
  VALUES ( {$vehicle_id}, '{$date}', '{$time}', {$speed}, {$lat}, {$lon} )";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo $vehicle_id . "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
?>
</body>
</html>

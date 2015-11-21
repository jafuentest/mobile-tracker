<!DOCTYPE html>
<?php $vehicle_id = $_POST['vehicle_id'] ?>
<html>
  <head>
    <title>GPS TangoMesh</title>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%; }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
      var map;
      var marker;

      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition( showPosition, showError );
        } else {
          console.log ('Geolocation is not supported by this browser.');
        }
      }

      function updatePosition(position) {
        latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        marker.setPosition(latlng);
        speed = position.coords.speed ? position.coords.speed : 'null';
        $.post( "http://tangomesh.tk/gps/insert.php", {
          vehicle_id: <?php echo $vehicle_id ?>,
          time: new Date().getTime(),
          lat: position.coords.latitude,
          lon: position.coords.longitude,
          speed: speed
        }, function(data) {console.log(data);});
      }

      function showError(error) {
        switch(error.code) {
          case error.PERMISSION_DENIED:
            console.log ('User denied the request for Geolocation.');
            break;
          case error.POSITION_UNAVAILABLE:
            console.log ('Location information is unavailable.');
            break;
          case error.TIMEOUT:
            console.log ('The request to get user location timed out.');
            break;
          case error.UNKNOWN_ERROR:
            console.log ('An unknown error occurred.');
            break;
        }
      }

      function showPosition(position) {
        var myLatLng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        
        map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          scrollwheel: false,
          zoom: 18
        });

        marker = new google.maps.Marker({
          map: map,
          position: myLatLng,
          title: 'Hello World !'
        });

        loop();
      }

      function loop() {
        setTimeout(function(){
          navigator.geolocation.getCurrentPosition( updatePosition, showError );
          loop();
        }, 2000);
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=getLocation"></script>
  </body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 90%;
        width: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .btn {
        border: none;
        background-color: inherit;
        padding: 14px 28px;
        font-size: 16px;
        cursor: pointer;
        display: inline-block;
        width: 100%;
        background: white;
      }

      .btn:hover {background: #eee;}

      .success {color: green;}
      .info {color: dodgerblue;}
      .warning {color: orange;}
      .danger {color: red;}
      .default {color: black;}

      .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: green;
        text-align: center;
      }
    </style>
  </head>
  <body>

    <?php
      $id = $_GET['id'];
      echo '<script type="text/javascript">';
      echo "var id = '$id';"; 
      echo '</script>';
    ?>

    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow, pos ,Jlat,Jlng;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 17
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            Jlng = position.coords.longitude;
            Jlat = position.coords.latitude
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

      function myFunction(){
        alert("ID " + id + " Check In.");
        window.location.href = "mqtt.php?id=" + id + "&lat=" + Jlat + "&lng=" + Jlng;
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDR5SxRmQaN3h5Ow4T-Gaojrg9M_3iNP3I&callback=initMap">
    </script>
    <div>
        <button class="btn" onclick="myFunction()"  onmouseover="this.style.cursor='pointer';"">Check In</button>
    </div>
  </body>
</html>
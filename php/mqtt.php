<?php
  require("phpMQTT.php");
  
  $server = "202.28.244.147";     // change if necessary
  $port = 1883;                     // change if necessary
  $username = "scn";                   // set your username
  $password = "df2831";                   // set your password
  $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()
  
  $mqtt = new phpMQTT($server, $port, $client_id);

  $id = $_GET['id'];
  $lat = $_GET['lat'];
  $lng = $_GET['lng'];

  if ($mqtt->connect(true, NULL, $username, $password)) {
    $mqtt->publish("truck/checkin", "$id,$lat,$lng", 0);
    $mqtt->close();
    } 
    else {
      echo "Time out!\n";
  }

  echo "Thank You! --> {data: $id,$lat,$lng}";

?>
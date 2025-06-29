<?php

  $host = ""; 
  $user = "";
  $pass = "";
  $db = "";
  $port = "";

  $conn = mysqli_connect($host,$user,$pass,$db,$port);     // same order

  if(!$conn){
    die(mysqli_connect_error());
  }



?>
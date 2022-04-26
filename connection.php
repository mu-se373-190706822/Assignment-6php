<?php  
$servername = "mysql:host=localhost;dbname=client";  
$username = "root";  
$password = "";  
$database = "registerlogin";  
$mysqli = new mysqli("localhost","root","","client");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>
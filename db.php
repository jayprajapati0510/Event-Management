<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_db";

$conn = mysqli_connect($host,$user,$password,$dbname);

if(!$conn){
	echo "Connection Failed";
}

$conn->set_charset("utf8");

?>
<?php
//connect to mysql

$host="localhost";
$username="hironam";
$pass="542694";
$database="hironam";



$mysqli = new mysqli($host, $username, $pass, $database);

/*
$user = 'root';
$password = 'root';
$db = 'hironam';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);
*/


if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
?>
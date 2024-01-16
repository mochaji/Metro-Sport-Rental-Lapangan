<?php
	$host="localhost";
	$user="root";
	$pass="";
	$dbname="laravel_lumen";

	$connect=mysqli_connect($host,$user,$pass,$dbname) or die(mysqli_error());
	$conn = new mysqli($host, $user, $pass, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	  }
	  

?>

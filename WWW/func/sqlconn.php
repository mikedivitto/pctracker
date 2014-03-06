<?php
	include_once("config.php");
	$con=mysqli_connect($DB_HOST,$DB_UNAM,$DB_PASW,$DB_NAME);
	if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
?>
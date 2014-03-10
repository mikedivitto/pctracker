<?php
	/*echo "<p>Hostname:  " . $_GET['hname'] . "</p>";
	echo "<p>Timestamp: " . $_GET['tstamp'] . "</p>";
	echo "<p>Current Time: " . time() . "</p>";*/
	include_once('sqlconn.php');
	$query = sprintf("UPDATE `comptest` SET `TIMESTAMP`=\"%s\" WHERE `HOSTNAME`=\"%s\"",
		mysqli_real_escape_string($con,$_GET['tstamp']),
		mysqli_real_escape_string($con,$_GET['hname']));
	/*echo "<p>Sending Query: " . $query . "</p>";*/
	mysqli_query($con,$query);
	mysqli_close($con);
?>

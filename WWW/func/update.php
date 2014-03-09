<?php
	/*echo "<p>Hostname:  " . $_GET['hname'] . "</p>";
	echo "<p>Username:  " . $_GET['uname'] . "</p>";
	echo "<p>Timestamp: " . $_GET['tstamp'] . "</p>";
	echo "<p>Current Time: " . time() . "</p>";*/
	include_once('sqlconn.php');
	$query = "UPDATE comptest SET UNAME=" . $_GET['uname'] . ",TIMESTAMP=" . $_GET['tstamp'] . " WHERE HOSTNAME=" . $_GET['hname'];
	/*echo "<p>Sending Query: " . $query . "</p>";*/
	mysqli_query($con,$query);
	mysqli_close($con);
?>

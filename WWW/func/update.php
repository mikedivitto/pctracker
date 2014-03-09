<?php
	/*echo "<p>Hostname:  " . $_GET['hname'] . "</p>";
	echo "<p>Username:  " . $_GET['uname'] . "</p>";
	echo "<p>Timestamp: " . $_GET['tstamp'] . "</p>";
	echo "<p>Current Time: " . time() . "</p>";*/
	include_once('sqlconn.php');
	$query = sprintf("UPDATE comptest SET UNAME=%s,TIMESTAMP=%s WHERE HOSTNAME=%s",
		mysql_real_escape_string($_GET['uname']),mysql_real_escape_string($_GET['tstamp']),
		mysql_real_escape_string($_GET['hname']));
	/*echo "<p>Sending Query: " . $query . "</p>";*/
	mysqli_query($con,$query);
	mysqli_close($con);
?>

<?php
include_once('config.php');
if(class_exists('Memcache')){
	$key = 'openlabs_comp_' . strtoupper($_GET['hname']);
	$value = $_GET['tstamp'];
	$mc = new Memcache;
	$mc->connect($MC_SERVER, $MC_PORT);
	if(!$mc->set($key, $value)){
		include_once('sqlconn.php');
		$query = sprintf("UPDATE `" . $DB_COMPUTERS . "` SET `TIMESTAMP`=\"%s\" WHERE `HOSTNAME`=\"%s\"",
		mysqli_real_escape_string($con,$_GET['tstamp']),
		mysqli_real_escape_string($con,$_GET['hname']));
		mysqli_query($con,$query);
		mysqli_close($con);
	}
	$mc->close();
}
else{
	include_once('sqlconn.php');
	$query = sprintf("UPDATE `" . $DB_COMPUTERS . "` SET `TIMESTAMP`=\"%s\" WHERE `HOSTNAME`=\"%s\"",
	mysqli_real_escape_string($con,$_GET['tstamp']), mysqli_real_escape_string($con,$_GET['hname']));
	mysqli_query($con,$query);
	mysqli_close($con);
}
?>
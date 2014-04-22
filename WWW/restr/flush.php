<?php
session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	$_SESSION['message'] = "Not Logged In.";
	header("Location: ../admin/login.php");
	exit();
}
if($_SESSION['level'] == 0)
	{
	if(class_exists('Memcache'))
	{
		$mc = new Memcache;
		$mc->connect('localhost', 11211);
		$mc->flush();
		$_SESSION['message'] =  "Cache Flushed";
		$mc->close();
	}
	else
	{
		$_SESSION['message'] =  "Memcache not installed.";
	}
	header("Location: ../admin/index.php");
	exit();
}
else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/login.php");
	exit();
} ?>
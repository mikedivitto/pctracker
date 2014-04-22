<?php

session_start();

if(isset($_SESSION['message']))
{
	$sendstr = $_SESSION['message'];
	session_unset();
	session_destroy();
	header("Location: ./login.php");
	exit();
}

session_unset();
session_destroy();
header("Location: ../");

?>
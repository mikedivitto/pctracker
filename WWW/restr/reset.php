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
include_once('../func/sqlconn.php');
include_once('../func/config.php');
	$sqla="DELETE FROM `" . $DB_BUILDINGS . "` WHERE 1";
	$sqlb="DELETE FROM `" . $DB_COMPUTERES . "` WHERE 1";
	$sqlc="DELETE FROM `" . $DB_ROOMS . "` WHERE 1";
	if (!mysqli_query($con,$sqla)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlb)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlc)){die('Error: ' . mysqli_error($con));}
	$_SESSION['message'] =  "ALL DATA ERASED";
	mysqli_close($con);
	header("Location: ../admin/index.php");
	exit();
	}
	else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/login.php");
	exit();
}
?>
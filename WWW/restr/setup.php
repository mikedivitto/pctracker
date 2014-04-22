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
	include_once('../func/config.php');
	include_once('../func/sqlconn.php');
	$sqla="CREATE TABLE " . $DB_COMPUTERS . " (ID INT NOT NULL AUTO_INCREMENT, HOSTNAME TEXT NOT NULL, OS TEXT NOT NULL, BUILDING TEXT NOT NULL, ROOM TEXT NOT NULL, COMPNO TEXT NOT NULL, TIMESTAMP TEXT, SERVICE INT NOT NULL, UNAME TEXT, PRIMARY KEY ( ID ))";
	$sqlb="CREATE TABLE " . $DB_BUILDINGS . " (ID INT(11) NOT NULL AUTO_INCREMENT, NAME TEXT NOT NULL, PRIMARY KEY(ID))";
	$sqlc="CREATE TABLE " . $DB_ROOMS . " (ID INT(11) NOT NULL AUTO_INCREMENT, BUILDING TEXT NOT NULL, ROOM TEXT NOT NULL, PRIMARY KEY(ID))";
	$sqld="CREATE TABLE " . $DB_USERINFO . " (ID INT(10) NOT NULL AUTO_INCREMENT UNSIGNED, EMAIL TEXT NOT NULL, PASSWORD TEXT NOT NULL, LEVEL INT(11) NOT NULL, NICKNAME TEXT NOT NULL, PRIMARY KEY(ID))";
	mysqli_query($con,$sqla);
	mysqli_query($con,$sqlb);
	mysqli_query($con,$sqlc);
	$_SESSION['message'] = "Database Prepared";
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
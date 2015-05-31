<?php

session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	header("Location: ./login.php");
	exit();
}

$timeh = time();

if($_SESSION['timeout'] > ($timeh + 1800))
{
	header("Location: ./logout.php");
	$_SESSION['message'] = "User timed out (30 minutes)";
	exit();
}
else
{
	$_SESSION['timeout'] = $timeh;
}

include_once("Computers.php");
$comp = new Computers();
$data = $comp->getAll_JSON();
header('Content-Type: application/json');
echo $data;
exit();
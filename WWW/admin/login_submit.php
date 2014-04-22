<?php

session_start();

if(!isset($_POST['id'], $_POST['password']))
{
	$_SESSION['message'] = "Something went wrong...";
	header("Location: ./login.php");
}

include_once("../func/sqlconn.php");
$uid = mysqli_real_escape_string($con, $_POST['id']);
$sql = "SELECT * FROM " . $DB_USERINFO . " WHERE email='" . $uid . "'";
$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);


if($row == null)
{
	$_SESSION['message'] = "User not found.";
	header("Location: ./login.php");
	exit();
}

if (crypt($_POST['password'], $row['password']) == $row['password']) {
	$_SESSION['status'] = 1;
	$_SESSION['id'] = $row['id'];
	$_SESSION['nickname'] = $row['nickname'];
	$_SESSION['level'] = $row['level'];
	$_SESSION['email'] = $row['email'];
	header("Location: ./index.php");
}
else {
	$_SESSION['message'] = "Incorrect Password.";
	header("Location: ./login.php");
}
$con->close();
?>
<?php
$PageTitle="Record Added";
function customPageHeader(){?>
<?php }

session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	$_SESSION['message'] = "Not Logged In.";
	header("Location: ../admin/login.php");
	exit();
}
if($_SESSION['level'] == 0)
{
	include_once('config.php');
	if(strlen($_POST[hname]) == 0){$_SESSION['message'] = "ERROR: NO HOSTNAME SPECIFIED.";}
	else
	{
		include_once('sqlconn.php');
		$result = mysqli_query($con,"SELECT * FROM `" . $DB_ROOMS . "`");	
		$buildings = array();
		$rooms = array();
		while($row = mysqli_fetch_array($result)) 
		{
			if(!in_array($row['BUILDING'],$buildings)){array_push($buildings,$row['BUILDING']);}
			if(!in_array($row['ROOM'],$rooms)){array_push($rooms,$row['ROOM']);	}
		}
		if(!in_array($_POST['bldg'],$buildings))
		{
			$addb=sprintf("INSERT INTO `" . $DB_BUILDINGS . "` (NAME) VALUES ('%s')",mysqli_real_escape_string($con,$_POST[bldg]));
			$addr=sprintf("INSERT INTO `" . $DB_ROOMS . "` (BUILDING, ROOM) VALUES ('%s','%s')",mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]));
			if (!mysqli_query($con,$addb)){die('Error: ' . mysqli_error($con));}
			if (!mysqli_query($con,$addr)){die('Error: ' . mysqli_error($con));}
			$_SESSION['message'] = $_SESSION['message'] . "Building and Room added. ";
		}		
		else if(in_array($_POST['bldg'],$buildings) && !in_array($_POST['room'],$rooms))
		{
			$addr=sprintf("INSERT INTO `" . $DB_ROOMS . "` (BUILDING, ROOM) VALUES ('%s','%s')",mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]));
			if (!mysqli_query($con,$addr)){die('Error: ' . mysqli_error($con));}
			$_SESSION['message'] = $_SESSION['message'] . "Room added. ";
		}
		$sql=sprintf("INSERT INTO " . $DB_COMPUTERS . " (HOSTNAME, BUILDING, ROOM, COMPNO, SERVICE, OS)
		VALUES ('%s','%s','%s','%s','%s','%s')",mysqli_real_escape_string($con,$_POST[hname]),mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]),mysqli_real_escape_string($con,$_POST[comp]),mysqli_real_escape_string($con,$_POST[srvc]),mysqli_real_escape_string($con,$_POST[os]));
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
		$_SESSION['message'] = $_SESSION['message'] . "Record added. ";
		mysqli_close($con);		
	}
	header("Location: ../admin/");
	exit();
}
else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/login.php");
	exit();
}
include_once('footer.php');
?> 


















include_once('../admin/headernl.php');

include_once('footer.php');
?> 
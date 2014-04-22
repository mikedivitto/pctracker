<?php
$PageTitle="Update Info";
function customPageHeader(){?>
<?php }

session_start();
include_once('config.php');
if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	$_SESSION['message'] = "Not Logged In.";
	header("Location: ../admin/login.php");
	exit();
}
if($_SESSION['level'] == 0)
{
	include_once('sqlconn.php');
	$query = sprintf("UPDATE `" . $DB_COMPUTERS . "` SET `OS`=\"%s\",`BUILDING`=\"%s\",`ROOM`=\"%s\",`COMPNO`=\"%s\",`SERVICE`=\"%s\" WHERE `ID`=\"%s\"",
		mysqli_real_escape_string($con,$_POST['os']),mysqli_real_escape_string($con,$_POST['bldg']),
		mysqli_real_escape_string($con,$_POST['room']),mysqli_real_escape_string($con,$_POST['comp']),
		mysqli_real_escape_string($con,$_POST['srvc']),mysqli_real_escape_string($con,$_POST['id']));	
	mysqli_query($con,$query);	
	mysqli_close($con);
	$_SESSION['message'] = "Record Updated";
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

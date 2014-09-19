<?php
$PageTitle="Record Deleted";
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
	if(strlen($_POST[id]) == 0){$_SESSION['message'] = "ERROR: NO HOST SPECIFIED.";}
	else
	{
		include_once('sqlconn.php');
		$sql=sprintf("DELETE FROM " . $DB_COMPUTERS . " WHERE `ID`=\"%s\"",mysqli_real_escape_string($con,$_POST['id']));	
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}	
		$_SESSION['message'] = "Record Deleted";
		mysqli_close($con);
	}
	header("Location: ../admin/");
	exit();
}
else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin");
	exit();
}
include_once('footer.php');
?> 
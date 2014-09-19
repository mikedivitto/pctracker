<?php
$PageTitle="User Added";
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
	if(strlen($_POST[uname]) == 0){$_SESSION['message'] = "ERROR: NO HOSTNAME SPECIFIED.";}
	else
	{
		include_once('sqlconn.php');
		$result = mysqli_query($con,"SELECT * FROM `" . $DB_USERINFO . "`");	
		$users = array();
		while($row = mysqli_fetch_array($result)) 
		{
			if(!in_array($row['EMAIL'],$users)){array_push($users,$row['EMAIL']);}
		}
		if(!in_array($_POST['uname'],$users))
		{
			$addb=sprintf("INSERT INTO `" . $DB_USERINFO . "` (EMAIL, PASSWORD, NICKNAME, LEVEL) VALUES ('%s','%s','%s','%s')",mysqli_real_escape_string($con,$_POST[uname]),crypt(mysqli_real_escape_string($con,$_POST[pwd1])),mysqli_real_escape_string($con,$_POST[name]),mysqli_real_escape_string($con,$_POST[level]));
			if (!mysqli_query($con,$addb)){die('Error: ' . mysqli_error($con));}
			$_SESSION['message'] = $_SESSION['message'] . "User Added";
		}		
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